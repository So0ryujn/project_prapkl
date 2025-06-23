<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil data POST
$id_pesanan = $_POST['id_pesanan'] ?? null;
$action = $_POST['action'] ?? null;

if (!$id_pesanan || $action !== 'canceled') {
    header("Location: produk-canceled.php?error=invalid");
    exit;
}

$id_pesanan = mysqli_real_escape_string($koneksi, $id_pesanan);

// Update status
$query = "UPDATE pesanan SET status = 'canceled' WHERE id_pesanan = '$id_pesanan'";
$result = mysqli_query($koneksi, $query);

if ($result) {
    // Redirect ke halaman produk yang sudah completed
    header("Location: produk-canceled.php?success=1");
    exit;
} else {
    header("Location: produk-pending.php?error=1");
    exit;
}
?>
