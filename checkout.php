<?php
ob_start();
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
$users = mysqli_fetch_assoc($query_user);

// Ambil kota dan tarif ongkir
$query_kota = mysqli_query($koneksi, "SELECT * FROM ongkir");

// Ambil produk dari keranjang user
$query_keranjang = mysqli_query($koneksi, "
    SELECT keranjang.id_keranjang, keranjang.jumlah, produk.id_produk, produk.nama_produk, produk.harga_produk, produk.diskon
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk
    WHERE keranjang.id_user = '$id_user'
");

$items = [];
$total = 0;
$diskon = 0;

while ($item = mysqli_fetch_assoc($query_keranjang)) {
    $items[] = $item;
    $subtotal = $item['harga_produk'] * $item['jumlah'];
    $total += $subtotal;
    $diskon += ($item['diskon'] * $item['jumlah']);
}

$total_setelah_diskon = $total - $diskon;

// Handle proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $produk     = $_POST['produk'];
        $total      = (int)$_POST['total'];
        $diskon     = (int)$_POST['diskon'];
        $ongkir     = (int)$_POST['tarif'];
        $id_ongkir  = (int)$_POST['id_ongkir'];
        $pembayaran = $_POST['metode-bayar'];
        $alamat     = $users['alamat'];
        $total_bayar = $total - $diskon + $ongkir;

        if ($total < 0 || $ongkir < 0 || $id_ongkir <= 0 || empty($produk)) {
            throw new Exception("Data input tidak valid.");
        }

        $cek_ongkir = mysqli_query($koneksi, "SELECT * FROM ongkir WHERE id_ongkir = '$id_ongkir'");
        if (mysqli_num_rows($cek_ongkir) == 0) {
            throw new Exception("Ongkir tidak ditemukan.");
        }

        // Upload bukti pembayaran
        $bukti       = $_FILES['bukti-tf']['name'];
        $tmp         = $_FILES['bukti-tf']['tmp_name'];
        $upload_dir  = "uploads/";
        $upload_path = $upload_dir . time() . '_' . basename($bukti);

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        if (!move_uploaded_file($tmp, $upload_path)) {
            throw new Exception("Gagal upload bukti pembayaran.");
        }

        // Simpan ke DB
        mysqli_begin_transaction($koneksi);

        $jumlah_produk = 0;
        $nama_produk_all = [];
        $id_produk_pertama = 0;

        foreach ($produk as $i => $item) {
            $jumlah_produk += $item['jumlah'];
            $nama_produk_all[] = $item['nama'];
            if ($i === 0) {
                $id_produk_pertama = $item['id_produk'];
            }
        }

        $nama_produk = implode(", ", $nama_produk_all);

        // Insert pesanan
        $query_pesanan = mysqli_query($koneksi, "
            INSERT INTO pesanan 
            (id_user, id_ongkir, id_produk, tgl_pesan, nama_produk, jumlah_produk, alamat, ongkir, total, status)
            VALUES
            ('$id_user', '$id_ongkir', '$id_produk_pertama', NOW(), '$nama_produk', '$jumlah_produk', '$alamat', '$ongkir', '$total', 'Belum Diproses')
        ");

        if (!$query_pesanan) throw new Exception("Gagal menyimpan pesanan.");

        $id_pesanan = mysqli_insert_id($koneksi);

        // Insert pembayaran
        $query_bayar = mysqli_query($koneksi, "
            INSERT INTO pembayaran
            (id_pesanan, id_user, total, ongkir, total_bayar, pembayaran, bukti_bayar, tgl_pesan)
            VALUES
            ('$id_pesanan', '$id_user', '$total', '$ongkir', '$total_bayar', '$pembayaran', '$upload_path', NOW())
        ");

        if (!$query_bayar) throw new Exception("Gagal menyimpan pembayaran.");

        $id_transaksi = mysqli_insert_id($koneksi);

        // Detail transaksi + hapus keranjang
        foreach ($produk as $item) {
            $id_keranjang = $item['id_keranjang'];
            $id_produk    = $item['id_produk'];
            $nama_produk  = $item['nama'];
            $harga        = $item['harga'];
            $jumlah       = $item['jumlah'];
            $subtotal     = $jumlah * $harga;

            mysqli_query($koneksi, "
                INSERT INTO detail_transaksi
                (id_transaksi, id_produk, nama_produk, jumlah, harga, subtotal)
                VALUES
                ('$id_transaksi', '$id_produk', '$nama_produk', '$jumlah', '$harga', '$subtotal')
            ");

            mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");
        }

        mysqli_commit($koneksi);
        $_SESSION['success'] = "Pesanan berhasil diproses.";
        header("Location: checkout.php");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        $_SESSION['error'] = $e->getMessage();
        header("Location: checkout.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Checkout - Meijin Meals</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <p><strong>Nama:</strong> <?= $users['nama']; ?></p>
        <p><strong>No HP:</strong> <?= $users['no_hp']; ?></p>
        <p><strong>Alamat:</strong> <?= $users['alamat']; ?></p>

        <label for="kota">Pilih Kota:</label>
        <select name="tarif" id="kota" onchange="updateTarif()" class="form-select" required>
            <option value="">-- Pilih Kota --</option>
            <?php while ($row = mysqli_fetch_assoc($query_kota)) { ?>
                <option value="<?= $row['tarif'] ?>" data-id="<?= $row['id_ongkir'] ?>"><?= $row['nama_kota'] ?></option>
            <?php } ?>
        </select>
        <input type="hidden" name="id_ongkir" id="id_ongkir">

        <hr>
        <h4>Produk</h4>
        <?php foreach ($items as $i => $item): ?>
            <input type="hidden" name="produk[<?= $i ?>][id_keranjang]" value="<?= $item['id_keranjang'] ?>">
            <input type="hidden" name="produk[<?= $i ?>][id_produk]" value="<?= $item['id_produk'] ?>">
            <input type="hidden" name="produk[<?= $i ?>][nama]" value="<?= $item['nama_produk'] ?>">
            <input type="hidden" name="produk[<?= $i ?>][harga]" value="<?= $item['harga_produk'] ?>">
            <input type="hidden" name="produk[<?= $i ?>][jumlah]" value="<?= $item['jumlah'] ?>">
            <p><?= $item['nama_produk'] ?> (<?= $item['jumlah'] ?> x Rp<?= number_format($item['harga_produk']) ?>)</p>
        <?php endforeach; ?>

        <input type="hidden" name="total" value="<?= $total ?>">
        <input type="hidden" name="diskon" value="<?= $diskon ?>">

        <p>Total Belanja: Rp<?= number_format($total) ?></p>
        <p>Diskon: Rp<?= number_format($diskon) ?></p>
        <p>Ongkir: Rp <input type="text" id="tarif" value="0" readonly class="form-control w-25 d-inline"></p>
        <p><strong>Total Bayar: Rp <span id="total-bayar"><?= number_format($total_setelah_diskon) ?></span></strong></p>

        <label for="metode-bayar">Metode Pembayaran</label>
        <select name="metode-bayar" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="BRI">BRI</option>
            <option value="BNI">BNI</option>
            <option value="ShopeePay">ShopeePay</option>
            <option value="Dana">Dana</option>
        </select>

        <label class="mt-3">Upload Bukti Pembayaran:</label>
        <input type="file" name="bukti-tf" class="form-control" required>

        <div class="mt-4 d-flex justify-content-between">
            <a href="keranjang.php" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Checkout</button>
        </div>
    </form>
</div>

<script>
function updateTarif() {
    const kota = document.getElementById('kota');
    const tarif = document.getElementById('tarif');
    const idOngkir = document.getElementById('id_ongkir');
    const totalBayar = document.getElementById('total-bayar');
    const diskonTotal = <?= $total_setelah_diskon ?>;

    const selected = kota.options[kota.selectedIndex];
    tarif.value = selected.value;
    idOngkir.value = selected.getAttribute('data-id');
    totalBayar.textContent = (parseInt(diskonTotal) + parseInt(tarif.value)).toLocaleString('id-ID');
}
</script>

</body>
</html>
<?php ob_end_flush(); ?>
