<?php
include "koneksi.php";
session_start();

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data produk dari POST
$produk = isset($_POST['produk']) ? $_POST['produk'] : [];
$total = isset($_POST['total']) ? (int)$_POST['total'] : 0;
$ongkir = isset($_POST['tarif']) ? (int)$_POST['tarif'] : 0;
$id_ongkir = isset($_POST['id_ongkir']) ? (int)$_POST['id_ongkir'] : 0;
$pembayaran = isset($_POST['metode-bayar']) ? $_POST['metode-bayar'] : '';

// Periksa apakah ada keranjang sementara dalam sesi (untuk backward compatibility)
$is_temp_cart = false;
if (isset($_SESSION['temp_cart'])) {
    $produk = $_SESSION['temp_cart'];
    $is_temp_cart = true;
}

// Validasi input
if ($total <= 0 || $ongkir < 0 || $id_ongkir <= 0 || empty($produk)) {
    $_SESSION['error'] = "Data input tidak valid.";
    header("Location: payment.php");
    exit;
}

// Cek ongkir
$cek_ongkir = mysqli_query($koneksi, "SELECT * FROM ongkir WHERE id_ongkir = '$id_ongkir'");
if (mysqli_num_rows($cek_ongkir) == 0) {
    $_SESSION['error'] = "Ongkir tidak ditemukan.";
    header("Location: payment.php");
    exit;
}

// Ambil alamat user
$query_user = mysqli_query($koneksi, "SELECT alamat FROM users WHERE id_user = '$id_user'");
$data_user = mysqli_fetch_assoc($query_user);
$alamat = $data_user['alamat'];

// Total bayar = total belanja + ongkir
$total_bayar = $total + $ongkir;

// Upload bukti bayar
$bukti = $_FILES['bukti-tf']['name'];
$tmp = $_FILES['bukti-tf']['tmp_name'];
$upload_dir = "uploads/";
$upload_path = $upload_dir . time() . '_' . basename($bukti);

// Buat folder jika belum ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!move_uploaded_file($tmp, $upload_path)) {
    $_SESSION['error'] = "Gagal upload bukti pembayaran.";
    header("Location: payment.php");
    exit;
}

// Mulai transaksi
mysqli_begin_transaction($koneksi);
try {
    // Siapkan data pesanan
    $jumlah_produk = 0;
    $nama_produk_all = [];
    $id_produk_pertama = 0;

    foreach ($produk as $index => $item) {
        $jumlah_produk += $item['jumlah'];

        // Deteksi apakah ini data "beli sekarang" atau dari keranjang
        if ($is_temp_cart) {
            // Data dari temp_cart (session)
            $nama_produk_all[] = $item['nama_produk'];
            if ($index === 0 && isset($item['id_produk'])) {
                $id_produk_pertama = $item['id_produk'];
            }
        } elseif (isset($item['id_produk'])) {
            // Data "beli sekarang" via POST (memiliki id_produk langsung)
            $nama_produk_all[] = $item['nama'];
            if ($index === 0) {
                $id_produk_pertama = $item['id_produk'];
            }
        } else {
            // Data dari keranjang normal (memiliki id_keranjang)
            $id_keranjang = isset($item['id_keranjang']) ? $item['id_keranjang'] : 0;

            $query_produk = mysqli_query($koneksi, "
                SELECT produk.id_produk, produk.nama_produk
                FROM keranjang
                JOIN produk ON keranjang.id_produk = produk.id_produk
                WHERE keranjang.id_keranjang = '$id_keranjang'
            ");
            $data_produk = mysqli_fetch_assoc($query_produk);

            if (!$data_produk) {
                throw new Exception("Produk tidak ditemukan untuk id_keranjang: $id_keranjang");
            }

            $nama_produk_all[] = $data_produk['nama_produk'];
            if ($index === 0) {
                $id_produk_pertama = $data_produk['id_produk'];
            }
        }
    }

    $nama_produk = implode(", ", $nama_produk_all);
    
    // Simpan ke tabel pesanan
    $query_pesanan = mysqli_query($koneksi, "
        INSERT INTO pesanan
        (id_user, id_ongkir, id_produk, tgl_pesan, nama_produk, jumlah_produk, alamat, ongkir, total, status)
        VALUES
        ('$id_user', '$id_ongkir', '$id_produk_pertama', NOW(), '$nama_produk', '$jumlah_produk', '$alamat', '$ongkir', '$total', 'Pending')
    ");

    if (!$query_pesanan) {
        throw new Exception("Gagal menyimpan pesanan: " . mysqli_error($koneksi));
    }

    $id_pesanan = mysqli_insert_id($koneksi);

    // Simpan ke tabel pembayaran
    $query_pembayaran = mysqli_query($koneksi, "
        INSERT INTO pembayaran
        (id_pesanan, id_user, total, ongkir, total_bayar, pembayaran, bukti_bayar, tgl_pesan)
        VALUES
        ('$id_pesanan', '$id_user', '$total', '$ongkir', '$total_bayar', '$pembayaran', '$upload_path', NOW())
    ");

    if (!$query_pembayaran) {
        throw new Exception("Gagal menyimpan pembayaran: " . mysqli_error($koneksi));
    }

    $id_transaksi = mysqli_insert_id($koneksi);

    // Simpan ke detail_transaksi & hapus dari keranjang
    foreach ($produk as $item) {
        $jumlah = $item['jumlah'];
        $harga = $item['harga'];
        $subtotal = $jumlah * $harga;

        // Tentukan id_produk dan nama_produk berdasarkan sumber data
        if ($is_temp_cart) {
            // Data dari temp_cart (session)
            $id_produk = $item['id_produk'];
            $nama_produk = $item['nama_produk'];
        } elseif (isset($item['id_produk'])) {
            // Data "beli sekarang" via POST
            $id_produk = $item['id_produk'];
            $nama_produk = $item['nama'];
        } else {
            // Data dari keranjang normal
            $id_keranjang = isset($item['id_keranjang']) ? $item['id_keranjang'] : 0;

            $query_produk = mysqli_query($koneksi, "
                SELECT produk.id_produk, produk.nama_produk
                FROM keranjang
                JOIN produk ON keranjang.id_produk = produk.id_produk
                WHERE keranjang.id_keranjang = '$id_keranjang'
            ");
            $data_produk = mysqli_fetch_assoc($query_produk);

            if (!$data_produk) {
                throw new Exception("Produk tidak ditemukan untuk id_keranjang: $id_keranjang");
            }

            $id_produk = $data_produk['id_produk'];
            $nama_produk = $data_produk['nama_produk'];
        }

        // Simpan ke detail_transaksi
        mysqli_query($koneksi, "
            INSERT INTO detail_transaksi
            (id_transaksi, id_produk, nama_produk, jumlah, harga, subtotal)
            VALUES
            ('$id_transaksi', '$id_produk', '$nama_produk', '$jumlah', '$harga', '$subtotal')
        ");

        // Hapus dari keranjang 
        if (!$is_temp_cart && isset($item['id_keranjang']) && $item['id_keranjang'] > 0) {
            mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang = '{$item['id_keranjang']}'");
        }
    }

    // Commit transaksi
    mysqli_commit($koneksi);

    // Bersihkan session 
    if ($is_temp_cart) {
        unset($_SESSION['temp_cart']);
    }

    $_SESSION['success'] = "Pesanan berhasil diproses.";
    header("Location: order.php");
    exit;

} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    mysqli_rollback($koneksi);

    $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    header("Location: payment.php");
    exit;
}
?>