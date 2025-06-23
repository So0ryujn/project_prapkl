<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari form
$id_kategori = $_POST['kategori'];
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok']; // Ambil nilai stok dari form
$deskripsi = $_POST['deskripsi'];

// Proses upload gambar
if(isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] == 0) {
    $nama_file = $_FILES['foto_produk']['name'];
    $tmp_file = $_FILES['foto_produk']['tmp_name'];
    $folder_tujuan = "../asset/menu/";
    
    // Buat folder jika belum ada
    if(!is_dir($folder_tujuan)) {
        mkdir($folder_tujuan, 0755, true);
    }
    
    // Generate nama unik untuk file
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_file_unik = uniqid() . '.' . $ext;
    $path_simpan = $folder_tujuan . $nama_file_unik;
    
    // Pindahkan file
    if(move_uploaded_file($tmp_file, $path_simpan)) {
        // Simpan ke database - TAMBAHKAN FIELD stok DI SINI
        $sql = "INSERT INTO produk (id_kategori, nama_produk, harga_produk, foto_produk, deskripsi, stok) 
                VALUES ('$id_kategori', '$nama_produk', '$harga', '$nama_file_unik', '$deskripsi', '$stok')";
        
        if(mysqli_query($koneksi, $sql)) {
            header("Location: produk.php?sukses=ditambahkan");
            exit();
        } else {
            // Tambahkan penanganan error yang lebih baik
            $error = "Gagal menyimpan ke database: " . mysqli_error($koneksi);
            header("Location: tambah_produk.php?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = "Gagal mengupload gambar";
        header("Location: tambah_produk.php?error=" . urlencode($error));
        exit();
    }
} else {
    $error = "Error upload gambar: " . $_FILES['foto_produk']['error'];
    header("Location: tambah_produk.php?error=" . urlencode($error));
    exit();
}
?>