<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$tanggal = date('Y-m-d H:i:s');
$status = "Menunggu Konfirmasi";

// Cek method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan amankan data dari form
    $id_ongkir = $_POST['id_ongkir'] ?? null;
    $metode = $_POST['metode-bayar'] ?? null;
    $tarif = intval($_POST['tarif'] ?? 0);
    $total = intval($_POST['total'] ?? 0);
    $diskon = intval($_POST['diskon'] ?? 0);
    $total_bayar = $total - $diskon + $tarif;

    // Cek dan proses upload file bukti transfer
    $path_file = null;
    if (isset($_FILES['bukti-tf']) && $_FILES['bukti-tf']['error'] === 0) {
        $nama_file = basename($_FILES['bukti-tf']['name']);
        $tmp_file = $_FILES['bukti-tf']['tmp_name'];
        $folder = "bukti_tf/";
        $path_file = $folder . time() . "_" . $nama_file;
        move_uploaded_file($tmp_file, $path_file);
    }

    // Simpan transaksi utama
    $query_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi 
        (id_user, id_ongkir, total, metode_bayar, bukti_tf, tanggal, status)
        VALUES 
        ('$id_user', '$id_ongkir', '$total_bayar', '$metode', '$path_file', '$tanggal', '$status')");

    if (!$query_transaksi) {
        die("Gagal menyimpan transaksi: " . mysqli_error($koneksi));
    }

    $id_transaksi = mysqli_insert_id($koneksi);

    // Simpan detail produk
    if (isset($_POST['produk']) && is_array($_POST['produk'])) {
        // Dari keranjang (bisa lebih dari 1 produk)
        foreach ($_POST['produk'] as $produk) {
            $nama = $produk['nama'];
            $harga = intval($produk['harga']);
            $jumlah = intval($produk['jumlah']);
            $subtotal = $harga * $jumlah;

            mysqli_query($koneksi, "INSERT INTO detail_transaksi 
                (id_transaksi, nama_produk, harga, jumlah, subtotal)
                VALUES 
                ('$id_transaksi', '$nama', '$harga', '$jumlah', '$subtotal')");

            // Hapus dari keranjang
            $id_keranjang = $produk['id_keranjang'] ?? null;
            if ($id_keranjang) {
                mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang'");
            }
        }
    } elseif (isset($_SESSION['beli_langsung'])) {
        // Beli langsung (jumlah 1)
        $data = $_SESSION['beli_langsung'];
        $id_produk = $data['id_produk'];
        $nama_produk = $data['nama_produk'];
        $harga = intval($data['harga_produk']);
        $jumlah = intval($data['jumlah']);
        $subtotal = $harga * $jumlah;

        mysqli_query($koneksi, "INSERT INTO detail_transaksi 
            (id_transaksi, nama_produk, harga, jumlah, subtotal)
            VALUES 
            ('$id_transaksi', '$nama_produk', '$harga', '$jumlah', '$subtotal')");

        unset($_SESSION['beli_langsung']); // hapus session beli langsung
    }

    // Redirect ke halaman status
    header("Location: status_transaksi.php");
    exit;
} else {
    echo "Akses tidak valid.";
}
?>
