<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Hitung total
$total_produk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk"));
$total_pesanan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan"));
$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users"));
$total_admin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM admin"));

// Hitung pesanan hari ini
$today = date('Y-m-d');
$pesanan_hari_ini = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE DATE(tgl_pesan) = '$today'"));

// Hitung total penjualan termasuk ongkir
$query_total_penjualan = mysqli_query($koneksi, 
    "SELECT SUM(p.total + o.tarif) as total_penjualan 
     FROM pesanan p 
     JOIN ongkir o ON p.id_ongkir = o.id_ongkir 
     WHERE p.status = 'Completed'");
$total_penjualan = mysqli_fetch_array($query_total_penjualan)['total_penjualan'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Dashboard Admin - Meijin Meals</title>
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
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #741212;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 18, 18, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.15);
        }

        .stat-card .icon {
            font-size: 2rem;
            color: #741212;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .stat-card:hover .icon {
            transform: scale(1.1);
        }

        .stat-card .number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #741212;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .trend {
            display: none;
        }
        
        .content-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(116, 18, 18, 0.1);
            margin-bottom: 30px;
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

        .order-id {
            font-weight: 700;
            color: #741212;
            font-size: 1.1rem;
        }

        .customer-name {
            font-weight: 600;
            color: #333;
        }

        .order-date {
            color: #666;
            font-style: italic;
        }

        .order-total {
            font-weight: 700;
            color: #28a745;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .status-completed {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-delivery {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            border: 1px solid #138496;
        }

        .status-canceled {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
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


        .empty-state p {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .quick-action-btn {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(116, 18, 18, 0.3);
        }

        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.4);
            color: white;
        }

        .quick-action-btn i {
            margin-right: 8px;
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
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stat-card {
                padding: 25px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header {
                padding: 25px;
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
                <li><a href="dashboard_admin.php" class="active">
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
                <li><a href="akun_admin.php">
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
            <h1>Dashboard Admin</h1>
            <p>Kelola sistem Meijin Meals dengan mudah dan efisien</p>
        </div>

        <div class="quick-actions">
            <a href="tambah_produk.php" class="quick-action-btn">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
            <a href="pesanan.php" class="quick-action-btn">
                <i class="fas fa-eye"></i> Lihat Pesanan
            </a>
            <a href="rekap.php" class="quick-action-btn">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="users.php" class="quick-action-btn">
                <i class="fas fa-users"></i> Kelola User
            </a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="number"><?php echo number_format($total_produk); ?></div>
                <div class="label">Total Produk</div>
            </div>
            
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="number"><?php echo number_format($total_user); ?></div>
                <div class="label">Total User</div>
            </div>
            
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="number"><?php echo number_format($total_pesanan); ?></div>
                <div class="label">Total Pesanan</div>
            </div>

            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="number">Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></div>
                <div class="label">Total Penjualan</div>
            </div>
        </div>
        
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-clock"></i> Pesanan Terbaru</h2>
            </div>
            
            <div class="table-container">
                <?php
                $query_pesanan = mysqli_query($koneksi, 
                    "SELECT p.*, u.nama, o.tarif 
                     FROM pesanan p 
                     JOIN users u ON p.id_user = u.id_user 
                     JOIN ongkir o ON p.id_ongkir = o.id_ongkir 
                     ORDER BY p.tgl_pesan DESC LIMIT 5");
                
                if(mysqli_num_rows($query_pesanan) > 0):
                ?>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID Pesanan</th>
                            <th><i class="fas fa-user"></i> Customer</th>
                            <th><i class="fas fa-calendar"></i> Tanggal</th>
                            <th><i class="fas fa-money-bill"></i> Total</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($pesanan = mysqli_fetch_array($query_pesanan)): ?>
                        <tr>
                            <td class="order-id">#<?php echo str_pad($pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td class="customer-name"><?php echo htmlspecialchars($pesanan['nama']); ?></td>
                            <td class="order-date"><?php echo date('d M Y H:i', strtotime($pesanan['tgl_pesan'])); ?></td>
                            <td class="order-total">
                                Rp <?php echo number_format($pesanan['total'] + $pesanan['tarif'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php 
                                $status_class = '';
                                if($pesanan['status'] == 'Completed') $status_class = 'status-completed';
                                elseif($pesanan['status'] == 'Delivery') $status_class = 'status-delivery';
                                elseif($pesanan['status'] == 'Pending') $status_class = 'status-pending';
                                else $status_class = 'status-canceled';
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $pesanan['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesanan masuk</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>