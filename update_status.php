<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pesanan = $_POST['id_pesanan'];
    $status = $_POST['status'];

    // Validasi status
    $valid_status = ['Belum Diproses', 'Diproses', 'Dikirim', 'Selesai'];
    if (!in_array($status, $valid_status)) {
        die("Status tidak valid.");
    }

    // Update status
    $query = "UPDATE pesanan SET status = ? WHERE id_pesanan = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id_pesanan);

    if (mysqli_stmt_execute($stmt)) {
        // Jika update sukses, redirect kembali ke halaman admin
        header("Location: pesanan.php?update=success");
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: pesanan.php");
}
?>
