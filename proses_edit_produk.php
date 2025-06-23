<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari form
$id_produk = $_POST['id_produk'];
$id_kategori = $_POST['kategori'];
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$deskripsi = $_POST['deskripsi'];

// Cek apakah ada file gambar yang diupload
if($_FILES['foto_produk']['error'] == 0) {
    // Ambil data produk lama untuk menghapus fotonya
    $query_produk = mysqli_query($koneksi, "SELECT foto_produk FROM produk WHERE id_produk = '$id_produk'");
    $produk_lama = mysqli_fetch_array($query_produk);
    
    // Hapus foto lama jika ada
    if($produk_lama && file_exists("../asset/menu/" . $produk_lama['foto_produk'])) {
        unlink("../asset/menu/" . $produk_lama['foto_produk']);
    }
    
    // Proses upload gambar baru
    $nama_file = $_FILES['foto_produk']['name'];
    $tmp_file = $_FILES['foto_produk']['tmp_name'];
    $folder_tujuan = "../asset/menu/";
    
    // Generate nama unik untuk file
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_file_unik = uniqid() . '.' . $ext;
    $path_simpan = $folder_tujuan . $nama_file_unik;
    
    // Pindahkan file
    if(move_uploaded_file($tmp_file, $path_simpan)) {
        // Update database termasuk foto baru
        $sql = "UPDATE produk SET 
                id_kategori = '$id_kategori',
                nama_produk = '$nama_produk',
                harga_produk = '$harga',
                stok = '$stok',
                deskripsi = '$deskripsi',
                foto_produk = '$nama_file_unik'
                WHERE id_produk = '$id_produk'";
    } else {
        header("Location: edit_produk.php?id=$id_produk&error=upload_gagal");
        exit();
    }
} else {
    // Update database tanpa mengubah foto
    $sql = "UPDATE produk SET 
            id_kategori = '$id_kategori',
            nama_produk = '$nama_produk',
            harga_produk = '$harga',
            stok = '$stok',
            deskripsi = '$deskripsi'
            WHERE id_produk = '$id_produk'";
}

// Eksekusi query
if(mysqli_query($koneksi, $sql)) {
    header("Location: produk.php?sukses=diupdate");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>