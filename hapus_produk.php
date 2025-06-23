<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: produk.php");
    exit();
}

$id_produk = $_GET['id'];

// Hapus gambar produk
$query_produk = mysqli_query($koneksi, "SELECT foto_produk FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_array($query_produk);

if($produk) {
    $file_path = "../asset/menu/" . $produk['foto_produk'];
    if(file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Hapus dari database
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk'");
}

header("Location: produk.php?sukses=dihapus");
exit();
?>