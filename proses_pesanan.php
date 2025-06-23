<?php
include "koneksi.php";
session_start();

// Cek login admin
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$id_pesanan = $_GET['id'];
$action = $_GET['action'];

// Validasi action
$valid_actions = ['complete', 'delivery', 'cancel'];
if(!in_array($action, $valid_actions)) {
    header("Location: pesanan.php");
    exit();
}

// Tentukan status baru berdasarkan action
switch($action) {
    case 'complete':
        $new_status = 'Completed';
        break;
    case 'delivery':
        $new_status = 'Delivery';
        break;
    case 'cancel':
        $new_status = 'Canceled';
        break;
    default:
        $new_status = 'Pending';
}

// Update status pesanan
$query = "UPDATE pesanan SET status = '$new_status' WHERE id_pesanan = '$id_pesanan'";
$result = mysqli_query($koneksi, $query);

if($result) {
    header("Location: pesanan.php?success=1");
} else {
    header("Location: pesanan.php?error=1");
}
?>