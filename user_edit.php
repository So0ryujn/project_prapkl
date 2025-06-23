<?php
session_start();

include "koneksi.php";

$id_user = $_POST['id_user'];
$username = $_POST['username'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

$sql = "UPDATE users SET username = '$username', nama = '$nama', email = '$email', no_hp = '$no_hp', alamat = '$alamat' WHERE id_user = '$id_user'";
$query = mysqli_query($koneksi, $sql);

if($query){
    header("location:user.php?edit=sukses");
}else{
    header("location:user.php?edit=gagal");
}
?>