<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])) {  // Diubah dari id_admin ke id
    header("Location: akun_admin.php");
    exit();
}

$id_admin = $_GET['id'];  // Diubah dari id_admin ke id

// Cek apakah admin ada
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
if(mysqli_num_rows($query) == 0) {
    header("Location: akun_admin.php?error=admin_tidak_ditemukan");
    exit();
}

// Hapus dari database
if(mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin = '$id_admin'")) {
    header("Location: akun_admin.php?sukses=dihapus");
} else {
    header("Location: akun_admin.php?error=gagal_hapus");
}
exit();
?>