<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id_produk = $_GET['id'];
$query_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
$produk = mysqli_fetch_array($query_produk);

if(!$produk) {
    header("Location: admin.php");
    exit();
}

$query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Meijin Meals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffff;
            margin: 0;
            color: #1A1111;
            display: flex;
        }
        
        .sidebar {
            width: 230px;
            background-color: #741212;
            height: 100vh;
            position: fixed;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar .logo img {
            width: 50px;
            margin-bottom: 30px;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar nav ul li {
            margin-bottom: 20px;
        }

        .sidebar nav ul li a {
            color: #ffff;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .sidebar nav ul li a:hover {
            background-color: #5a0e0e;
        }
        
        .main-content {
            margin-left: 270px;
            padding: 30px;
            width: calc(100% - 270px);
        }
        
        .card-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: #ffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(26,17,17,0.1);
            flex: 1;
            text-align: center;
        }
        
        .card h3 {
            margin-top: 0;
            color: #555;
        }
        
        .card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #741212;
            margin: 10px 0;
        }
        
        .card .icon {
            font-size: 2rem;
            color: #741212;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: #FFFFFF;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(26, 17, 17, 0.1);
            border: 1px solid #D9D9D9;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #D9D9D9;
        }

        th {
            background-color: #741212;
            color: #FFFFFF;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-edit {
            background-color: #f39c12;
            color: white;
        }
        
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-tambah {
            background-color: #2ecc71;
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .form-container {
            background: #FFFFFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(26, 17, 17, 0.1);
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #D9D9D9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #741212;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #D9D9D9;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
            background-color: #FFFFFF;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .form-group input[type="file"] {
            padding: 5px;
        }
        
        .btn-submit {
            background-color: #741212;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #5a0e0e;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="../asset/icon putih meijin.png" alt="Meijin Logo">
        </div>
        <nav>
            <ul>
                <li><a href="dashboard_admin.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="produk.php"><i class="fas fa-box"></i> Produk</a></li>
                <li><a href="pesanan.php"><i class="fas fa-box"></i> Pesanan</a></li>
                <li><a href="rekap.php"><i class="fa-solid fa-book"></i> Rekap Penjualan</a></li>
                <li><a href="contact_form.php" class="active"><i class="fas fa-envelope"></i> Kotak Masuk</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i> User</a></li>
                <li><a href="akun_admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>
    
    <div class="main-content">
        <h2>Edit Produk</h2>
        
        <div class="form-container">
            <form action="proses_edit_produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
                
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" required>
                        <?php while($kategori = mysqli_fetch_array($query_kategori)): ?>
                        <option value="<?php echo $kategori['id_kategori']; ?>" 
                            <?php if($kategori['id_kategori'] == $produk['id_kategori']) echo 'selected'; ?>>
                            <?php echo $kategori['nama_kategori']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" 
                           value="<?php echo $produk['nama_produk']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" 
                           value="<?php echo $produk['harga_produk']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" 
                           value="<?php echo $produk['stok']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" required><?php echo $produk['deskripsi']; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Foto Saat Ini</label>
                    <img src="asset/makanan/<?php echo $produk['foto_produk']; ?>" 
                         alt="Current Image" style="width: 100px; display: block; margin-bottom: 10px;">
                    <label for="foto_produk">Ganti Foto Produk</label>
                    <input type="file" name="foto_produk" id="foto_produk">
                    <small>Biarkan kosong jika tidak ingin mengganti foto</small>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Produk
                </button>
            </form>
        </div>
    </div>
</body>
</html>