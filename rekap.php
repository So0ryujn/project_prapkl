<?php
include "koneksi.php";
session_start();

// Cek login admin
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$current_year = date('Y');
$current_month = date('m');

$year = isset($_GET['year']) ? $_GET['year'] : $current_year;
$month = isset($_GET['month']) ? $_GET['month'] : $current_month;

// Query untuk detail pesanan completed
$query_sales = "
SELECT 
    p.id_pesanan,
    u.nama AS nama,
    p.tgl_pesan,
    p.total + o.tarif AS total_bayar,
    o.tarif,
    p.total AS total_produk
FROM pesanan p
JOIN users u ON p.id_user = u.id_user
JOIN ongkir o ON p.id_ongkir = o.id_ongkir
WHERE YEAR(p.tgl_pesan) = '$year'
  AND MONTH(p.tgl_pesan) = '$month'
  AND p.status = 'Completed'
ORDER BY p.tgl_pesan DESC
";

$result_sales = mysqli_query($koneksi, $query_sales);

// Query untuk total pemasukan dan jumlah pesanan
$query_summary = "
SELECT 
    COUNT(*) AS total_pesanan,
    SUM(p.total + o.tarif) AS total_pemasukan
FROM pesanan p
JOIN ongkir o ON p.id_ongkir = o.id_ongkir
WHERE YEAR(p.tgl_pesan) = '$year'
  AND MONTH(p.tgl_pesan) = '$month'
  AND p.status = 'Completed'
";
$result_summary = mysqli_query($koneksi, $query_summary);
$summary_data = mysqli_fetch_assoc($result_summary);

// Query untuk total bulanan
$query_total = "
    SELECT 
        SUM(p.total + o.tarif) as total_bulanan,
        COUNT(p.id_pesanan) as total_transaksi,
        COUNT(DISTINCT p.id_user) as total_customer
    FROM pesanan p
    JOIN ongkir o ON p.id_ongkir = o.id_ongkir
    WHERE YEAR(p.tgl_pesan) = '$year' 
    AND MONTH(p.tgl_pesan) = '$month'
    AND p.status = 'Completed'
";
$result_total = mysqli_query($koneksi, $query_total);
$total_data = mysqli_fetch_assoc($result_total);

// Query untuk mendapatkan tahun yang tersedia
$query_years = "SELECT DISTINCT YEAR(tgl_pesan) as year FROM pesanan WHERE status = 'Completed' ORDER BY year DESC";
$result_years = mysqli_query($koneksi, $query_years);

// Set default jika tidak ada data
if(!$total_data) {
    $total_data = [
        'total_bulanan' => 0,
        'total_transaksi' => 0,
        'total_customer' => 0
    ];
    $summary_data = [
        'total_pesanan' => 0,
        'total_pemasukan' => 0
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Rekap Penjualan - Meijin Meals</title>
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

        .filter-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(116, 18, 18, 0.1);
            margin-bottom: 30px;
        }

        .filter-header {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: white;
            padding: 20px 30px;
            border-bottom: none;
        }

        .filter-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .filter-content {
            padding: 25px 30px;
        }

        .filter-form {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .filter-group select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
            min-width: 120px;
            transition: all 0.3s ease;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #741212;
            box-shadow: 0 0 0 3px rgba(116, 18, 18, 0.1);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #741212, #8B1538);
            color: white;
            box-shadow: 0 4px 15px rgba(116, 18, 18, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.4);
        }

        .btn-print {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            margin-bottom: 20px;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
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

        .total-row {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-weight: 700;
            color: #741212;
        }

        .total-row td {
            border-top: 2px solid #741212;
            border-bottom: 2px solid #741212;
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

        .print-header {
            display: none;
        }

        /* Print Styles */
        @media print {
            .sidebar, .filter-container, .btn-print, .stats-grid {
                display: none;
            }
            
            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 20px;
            }
            
            .print-header img {
                width: 80px;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
            
            body {
                background: #fff;
                font-size: 12pt;
            }
            
            table {
                font-size: 10pt;
                width: 100%;
            }
            
            th, td {
                padding: 6px 8px;
            }

            .page-header {
                background: none;
                color: #333;
                box-shadow: none;
            }

            .section-header {
                background: none;
                color: #333;
                box-shadow: none;
            }
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

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                width: 100%;
            }

            .filter-group select {
                min-width: auto;
                width: 100%;
            }
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
                <li><a href="rekap.php" class="active">
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
            <h1>Rekap Penjualan</h1>
            <p>Pantau dan analisis performa penjualan bulanan dengan mudah</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="number"><?php echo number_format($total_data['total_transaksi']); ?></div>
                <div class="label">Total Transaksi</div>
            </div>
            
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="number"><?php echo number_format($total_data['total_customer']); ?></div>
                <div class="label">Total Customer</div>
            </div>
            
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="number">Rp <?php echo number_format($total_data['total_bulanan'], 0, ',', '.'); ?></div>
                <div class="label">Total Penjualan</div>
            </div>

            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="number"><?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?></div>
                <div class="label">Periode</div>
            </div>
        </div>

        <div class="filter-container">
            <div class="filter-header">
                <h3><i class="fas fa-filter"></i> Filter Periode</h3>
            </div>
            <div class="filter-content">
                <form method="get" action="" class="filter-form">
                    <div class="filter-group">
                        <label for="month">Bulan:</label>
                        <select name="month" id="month">
                            <?php for($m=1; $m<=12; $m++): ?>
                                <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0,0,0,$m,1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="year">Tahun:</label>
                        <select name="year" id="year">
                            <?php 
                            if(mysqli_num_rows($result_years) > 0):
                                while($year_data = mysqli_fetch_assoc($result_years)): ?>
                                    <option value="<?php echo $year_data['year']; ?>" <?php echo $year_data['year'] == $year ? 'selected' : ''; ?>>
                                        <?php echo $year_data['year']; ?>
                                    </option>
                                <?php endwhile;
                            else: ?>
                                <option value="<?php echo $current_year; ?>"><?php echo $current_year; ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </form>
            </div>
        </div>
        
        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        
        <div class="print-header">
            <img src="../asset/icon putih meijin.png" alt="Logo Meijin">
            <h2>Laporan Penjualan Bulanan</h2>
            <h3><?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?></h3>
        </div>
        
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-chart-bar"></i> Detail Pesanan Terjual</h2>
            </div>
            
            <div class="table-container">
                <?php if(mysqli_num_rows($result_sales) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> No</th>
                            <th><i class="fas fa-user"></i> Nama Pelanggan</th>
                            <th><i class="fas fa-calendar"></i> Tanggal Transaksi</th>
                            <th><i class="fas fa-money-bill"></i> Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($sales = mysqli_fetch_assoc($result_sales)): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($sales['nama']); ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($sales['tgl_pesan'])); ?></td>
                            <td>Rp <?php echo number_format($sales['total_bayar'], 0, ',', '.'); ?>
                                <small style="display: block; color: #666;">
                                    (Produk: Rp <?php echo number_format($sales['total_produk'], 0, ',', '.'); ?> + 
                                    Ongkir: Rp <?php echo number_format($sales['tarif'], 0, ',', '.'); ?>)
                                </small>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <tr class="total-row">
                            <td colspan="3"><strong>TOTAL</strong></td>
                            <td><strong>Rp <?php echo number_format($summary_data['total_pemasukan'], 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <p>Tidak ada data penjualan untuk periode yang dipilih</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>