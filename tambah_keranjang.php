<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

// Ambil harga produk dulu
$query_produk = mysqli_query($koneksi, "SELECT harga_produk FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_assoc($query_produk);

if (!$produk) {
    echo "Produk tidak ditemukan!";
    exit();
}

$harga = $produk['harga_produk'];
$total = $harga * $jumlah;

// Cek apakah produk sudah ada di keranjang user
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_user='$id_user' AND id_produk='$id_produk'");
if (mysqli_num_rows($cek) > 0) {
    // Kalau ada, update jumlah dan total
    mysqli_query($koneksi, "UPDATE keranjang 
        SET jumlah = jumlah + $jumlah, 
            total = total + $total 
        WHERE id_user='$id_user' AND id_produk='$id_produk'");
} else {
    // Kalau belum, masukkan produk baru
    mysqli_query($koneksi, "INSERT INTO keranjang (id_user, id_produk, jumlah, total) 
        VALUES ('$id_user', '$id_produk', '$jumlah', '$total')");
}

// Setelah itu arahkan ke halaman keranjang
header("location: cart2.php");
exit();
?>
