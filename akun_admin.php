<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$query_admin = mysqli_query($koneksi, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Kelola Admin - Meijin Meals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #1A1111;
            display: flex;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #741212 0%, #8B1538 100%);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        .sidebar .logo {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.05);
        }

        .sidebar .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .sidebar .logo img:hover {
            transform: scale(1.1);
            border-color: rgba(255,255,255,0.5);
        }

        .sidebar .logo h3 {
            color: white;
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .sidebar nav {
            padding: 20px 0;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin: 2px 10px;
        }

        .sidebar nav ul li a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .sidebar nav ul li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar nav ul li a:hover::before {
            left: 100%;
        }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .sidebar nav ul li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .sidebar nav ul li a:hover i {
            transform: scale(1.2);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 40px;
            background: linear-gradient(135deg, #741212, #8B1538);
            padding: 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.3);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .action-bar {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(116, 18, 18, 0.1);
            position: relative;
            overflow: hidden;
        }

        .action-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(116, 18, 18, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.4);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            color: white;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .alert {
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-success {
            color: #155724;
            border-left-color: #28a745;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .content-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(116, 18, 18, 0.1);
        }

        .section-header {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        .section-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .section-header i {
            margin-right: 10px;
        }
        
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #741212;
            padding: 20px 25px;
            text-align: left;
            font-weight: 700;
            font-size: 0.95rem;
            border-bottom: 3px solid #741212;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th i {
            margin-right: 8px;
        }

        td {
            padding: 18px 25px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .admin-id {
            font-weight: 700;
            color: #741212;
            font-size: 1.1rem;
        }

        .admin-username {
            font-weight: 700;
            color: #741212;
            font-size: 1.1rem;
        }

        .admin-email {
            color: #666;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        .empty-state p {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .total-info {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .total-info i {
            color: #741212;
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px 15px;
            }

            .action-bar {
                flex-direction: column;
                gap: 20px;
                align-items: stretch;
                text-align: center;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header {
                padding: 25px;
            }

            .table-container {
                font-size: 0.9rem;
            }

            th, td {
                padding: 12px 15px;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="../asset/icon putih meijin.png" alt="Meijin Logo">
            <h3>Meijin Meals</h3>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard_admin.php">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a></li>
                <li><a href="produk.php">
                    <i class="fas fa-box"></i> Produk
                </a></li>
                <li><a href="pesanan.php">
                    <i class="fas fa-shopping-cart"></i> Pesanan
                </a></li>
                <li><a href="rekap.php">
                    <i class="fa-solid fa-book"></i> Rekap Penjualan
                </a></li>
                <li><a href="contact_form.php">
                    <i class="fas fa-envelope"></i> Kotak Masuk
                </a></li>
                <li><a href="users.php">
                    <i class="fas fa-users"></i> User
                </a></li>
                <li><a href="akun_admin.php" class="active">
                    <i class="fas fa-user-shield"></i> Admin
                </a></li>
                <li><a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a></li>
            </ul>
        </nav>
    </aside>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-shield"></i> Kelola Admin</h1>
            <p>Kelola semua akun administrator Meijin Meals dengan mudah</p>
        </div>

        <div class="action-bar">
            <div>
                <a href="tambah_admin.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Admin Baru
                </a>
            </div>
            <div class="total-info">
                <i class="fas fa-info-circle"></i>
                <span>Total Admin: <strong><?php echo mysqli_num_rows($query_admin); ?></strong></span>
            </div>
        </div>
        
        <?php if(isset($_GET['sukses'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Berhasil!</strong> Admin berhasil <?php echo htmlspecialchars($_GET['sukses']); ?>!
        </div>
        <?php endif; ?>
        
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> Daftar Administrator</h2>
            </div>
            
            <div class="table-container">
                <?php if(mysqli_num_rows($query_admin) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Username</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($admin = mysqli_fetch_array($query_admin)): ?>
                        <tr>
                            <td class="admin-id">#<?php echo str_pad($admin['id_admin'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="admin-username"><?php echo htmlspecialchars($admin['user_admin']); ?></td>
                            <td class="admin-email"><?php echo htmlspecialchars($admin['email_admin']); ?></td>
                            <td>
                                <a href="hapus_admin.php?id=<?php echo $admin['id_admin']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus admin <?php echo htmlspecialchars($admin['user_admin']); ?>?\n\nTindakan ini tidak dapat dibatalkan!')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-user-shield"></i>
                    <p>Belum ada admin yang ditambahkan</p>
                    <p style="font-size: 1rem; margin-top: 10px; color: #999;">Klik tombol "Tambah Admin Baru" untuk memulai</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>