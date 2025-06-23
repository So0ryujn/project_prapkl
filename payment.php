<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
$users = mysqli_fetch_assoc($query_user);

// Ambil data kota dan tarif dari tabel ongkir
$query_kota = mysqli_query($koneksi, "SELECT * FROM ongkir");

$items = [];
$total = 0;
$is_beli_sekarang = false;

// Cek apakah mode beli langsung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['beli']) && $_POST['beli'] === 'sekarang') {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    $total = $harga * $jumlah;
    $is_beli_sekarang = true;

    $items[] = [
        'id_produk' => $id_produk,
        'nama_produk' => $nama_produk,
        'harga_produk' => $harga,
        'jumlah' => $jumlah
    ];

} else {    
    // Ambil produk dari keranjang user
    $query_keranjang = mysqli_query($koneksi, "
        SELECT keranjang.id_keranjang, keranjang.jumlah, produk.nama_produk, produk.harga_produk, produk.diskon
        FROM keranjang 
        JOIN produk ON keranjang.id_produk = produk.id_produk
        WHERE keranjang.id_user = '$id_user'
    ");

    while ($item = mysqli_fetch_assoc($query_keranjang)) {
        $items[] = $item;
        $subtotal = $item['harga_produk'] * $item['jumlah'];
        $total += $subtotal;
    }
}

$total_keseluruhan = $total;
$_SESSION['total_belanja'] = $total;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meijin Meals - Pembayaran</title>
    <link rel="stylesheet" href="payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 p-4 bg-light rounded" style="width:700px; background-color:white; box-shadow: 0 0 5px black; border-radius:10px;">
    <h2>MEIJIN MEALS</h2>
    <p style="color:#626f78; font-size:20px;"><strong>Bank: 1234567890</p></strong>
    <p style="color:#626f78;  font-size:20px;"><strong>E-Money: 0987654321</p></strong>
    <hr>

    <form method="post" action="proses_checkout.php" enctype="multipart/form-data">
        <div>
            <p>Nama: <?= $users['nama']; ?></p>
            <p>No HP: <?= $users['no_hp']; ?></p>
            <p>Alamat: <?= $users['alamat']; ?></p>

            <label for="nama_kota">Pilih Kota:</label>
            <select name="nama_kota" id="kota" onchange="updateTarif()" required class="form-select" data-id="">
                <option value="">-- Pilih Kota --</option>
                <?php 
                // Reset pointer untuk query kota
                mysqli_data_seek($query_kota, 0);
                while ($row = mysqli_fetch_assoc($query_kota)) { ?>
                    <option value="<?= $row['tarif'] ?>" data-id="<?= $row['id_ongkir'] ?>">
                        <?= $row['nama_kota'] ?>
                    </option>
                <?php } ?>
            </select>
            <input type="hidden" name="id_ongkir" id="id_ongkir" value="">
        </div>
        <br>

        <hr>

        <h4>Detail Produk</h4>
        <?php foreach ($items as $index => $item): ?>
            <?php if ($is_beli_sekarang): ?>
                <!-- Data untuk "beli sekarang" -->
                <input type="hidden" name="produk[<?= $index ?>][id_produk]" value="<?= $item['id_produk'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][nama]" value="<?= $item['nama_produk'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][harga]" value="<?= $item['harga_produk'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][jumlah]" value="<?= $item['jumlah'] ?>">
            <?php else: ?>
                <!-- Data untuk keranjang normal -->
                <input type="hidden" name="produk[<?= $index ?>][id_keranjang]" value="<?= $item['id_keranjang'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][nama]" value="<?= $item['nama_produk'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][harga]" value="<?= $item['harga_produk'] ?>">
                <input type="hidden" name="produk[<?= $index ?>][jumlah]" value="<?= $item['jumlah'] ?>">
            <?php endif; ?>
            
            <p><?= $item['nama_produk'] ?> (<?= $item['jumlah'] ?> x Rp<?= number_format($item['harga_produk']) ?>)</p>
        <?php endforeach; ?>

        <input type="hidden" name="total" value="<?= $total ?>">

        <div class="mt-3">
            <p>Total Belanja: Rp<?= number_format($total) ?></p>
            <p>Ongkir: Rp <input type="text" name="tarif" id="tarif" value="0" readonly class="form-control d-inline w-25"></p>
            <hr>
            <p><strong>Total Bayar: Rp <span id="total-bayar"><?= number_format($total) ?></span></strong></p>
        </div>

        <div class="mt-3">
            <label for="metode-bayar">Metode Pembayaran</label>
            <select name="metode-bayar" id="metode-bayar" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                <option value="BRI">BRI</option>
                <option value="BNI">BNI</option>
                <option value="ShopeePay">ShopeePay</option>
                <option value="Dana">Dana</option>
            </select>

            <label for="bukti-tf" class="mt-3">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti-tf" id="bukti-tf" class="form-control" required>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="cart2.php" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Checkout</button>
        </div>
    </form>
</div>

<script>
function updateTarif() {
    const kotaSelect = document.getElementById('kota');
    const tarifInput = document.getElementById('tarif');
    const idOngkirInput = document.getElementById('id_ongkir');
    
    const selectedOption = kotaSelect.options[kotaSelect.selectedIndex];
    const tarif = selectedOption.value;
    const idOngkir = selectedOption.getAttribute('data-id');

    tarifInput.value = tarif;
    idOngkirInput.value = idOngkir;

    const total = <?= $total_keseluruhan ?>;
    const totalBayarElem = document.getElementById('total-bayar');
    totalBayarElem.textContent = (parseInt(total) + parseInt(tarif)).toLocaleString('id-ID');
}
</script>

</body>
</html>