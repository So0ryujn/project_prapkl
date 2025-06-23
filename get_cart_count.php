<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo 0;
    exit;
}

$id_user = $_SESSION['id_user'];

// Hitung jumlah ID produk unik di keranjang
$q = mysqli_query($koneksi, "SELECT COUNT(DISTINCT id_produk) AS total FROM keranjang WHERE id_user = $id_user");
$d = mysqli_fetch_assoc($q);
echo $d['total'] ?? 0;
