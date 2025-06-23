<?php
include "koneksi.php";

$nama = $_POST['nama'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

$sql = "INSERT into users(nama, username, email, password, no_hp, alamat) VALUES ('$nama','$username', '$email', md5('$password'), '$no_hp', '$alamat')";
$query = mysqli_query($koneksi, $sql);

if($query) {
    header("location:login.php?register=sukses");
    exit;
}else{
    header("location:register.php?register=gagal");
    exit;
}
?>