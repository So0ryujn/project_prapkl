<?php
include "koneksi.php";
session_start();

if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Validasi input
if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: tambah_admin.php?error=field_kosong");
    exit();
}

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Gunakan password_hash

// Cek username sudah ada
$cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE user_admin = '$username'");
if(mysqli_num_rows($cek) > 0) {
    header("Location: tambah_admin.php?error=username_exists");
    exit();
}

// Cek email sudah ada
$cek_email = mysqli_query($koneksi, "SELECT * FROM admin WHERE email_admin = '$email'");
if(mysqli_num_rows($cek_email) > 0) {
    header("Location: tambah_admin.php?error=email_exists");
    exit();
}

$sql = "INSERT INTO admin (user_admin, email_admin, pass_admin) 
        VALUES ('$username', '$email', '$password')";

if(mysqli_query($koneksi, $sql)) {
    header("Location: akun_admin.php?sukses=ditambahkan");
} else {
    header("Location: tambah_admin.php?error=" . urlencode(mysqli_error($koneksi)));
}
exit();
?>