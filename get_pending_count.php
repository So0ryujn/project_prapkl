<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    echo 0;
    exit;
}

$id_user = $_SESSION['id_user'];

// Hitung jumlah pesanan dengan status 'Delivery'
$query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM pesanan 
    WHERE id_user = '$id_user' AND status = 'Pending'
");

$data = mysqli_fetch_assoc($query);
echo $data['total'] ?? 0;
