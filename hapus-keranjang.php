<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id_produk'])) {
    $id_keranjang = $_GET['id_produk'];
    $id_user = $_SESSION['id_user'];

    // Pastikan id_keranjang benar milik user ini supaya aman
    $query = "DELETE FROM keranjang WHERE id_keranjang = '$id_keranjang' AND id_user = '$id_user'";
    mysqli_query($koneksi, $query);

    header("Location: cart2.php");
    exit;
} else {
    // Jika id_produk tidak ada
    header("Location: cart2.php");
    exit;
}
?>
