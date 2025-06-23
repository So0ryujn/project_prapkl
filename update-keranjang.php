<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

$id_keranjang = $_POST['id_keranjang'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
$total = $jumlah * $harga;

$sql = "UPDATE keranjang SET jumlah = '$jumlah', total = '$total' WHERE id_keranjang = '$id_keranjang'";
$result = mysqli_query($koneksi, $sql);

if ($result) {
    echo "success";
} else {
    echo "error";
}
