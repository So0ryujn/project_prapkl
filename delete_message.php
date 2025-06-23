<?php
include "koneksi.php";
session_start();

// Cek login admin
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Hapus pesan dari database
$query = "DELETE FROM contact_form WHERE id_contactform = '$id'";
mysqli_query($koneksi, $query);

header("Location: contact_form.php?deleted=1");
exit();
?>