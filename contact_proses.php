<?php
session_start();
include "koneksi.php";

$id_user = $_POST['id_user'];
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Tambahkan validasi id_user jika perlu

$sql = "INSERT INTO contact_form (id_user, name, email, subject, message) 
        VALUES ('$id_user', '$name', '$email', '$subject', '$message')";
$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("Location: index.php?berhasil_dikirim");
} else {
    echo "Error: " . mysqli_error($koneksi);
    // Atau redirect ke error page: header("Location: index.php?gagal_dikirim");
}
?>
