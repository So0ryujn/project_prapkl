<?php
include "koneksi.php";
session_start();

// Cek login admin
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$id_pesanan = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data pesanan
$query_pesanan = "SELECT pesanan.*, users.nama, users.email, users.no_hp, users.alamat, 
                         ongkir.nama_kota, ongkir.tarif, 
                         pembayaran.bukti_bayar, pembayaran.total_bayar, pembayaran.total
                  FROM pesanan 
                  JOIN users ON pesanan.id_user = users.id_user 
                  JOIN ongkir ON pesanan.id_ongkir = ongkir.id_ongkir
                  LEFT JOIN pembayaran ON pesanan.id_pesanan = pembayaran.id_pesanan
                  WHERE pesanan.id_pesanan = '$id_pesanan'";

$pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, $query_pesanan));
$bukti = $pesanan['bukti_bayar'];
$total_bayar = $pesanan['total_bayar'];

// Hitung total pembayaran (produk + ongkir)
$total_produk = $pesanan['total'];
$total_pembayaran = $pesanan['total'] + $pesanan['tarif'];

// Ambil data pembayaran jika ada
$query_pembayaran = "SELECT * FROM pembayaran WHERE id_pesanan = '$id_pesanan'";
$pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, $query_pembayaran));

// Ambil item pesanan (dari nama_produk yang disimpan di pesanan)
$items = explode(", ", $pesanan['nama_produk']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Detail Pesanan - Meijin Meals</title>
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

        .section-content {
            padding: 30px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid rgba(116, 18, 18, 0.1);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 18, 18, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .detail-card:hover::before {
            left: 100%;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.15);
        }

        .detail-card h3 {
            color: #741212;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(116, 18, 18, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-card h3 i {
            font-size: 1.1rem;
        }

        .detail-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .detail-label {
            width: 140px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            color: #333;
            font-size: 0.95rem;
            word-break: break-word;
        }

        .total-section {
            background: rgba(116, 18, 18, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-label {
            font-weight: 600;
            color: #555;
        }

        .total-value {
            font-weight: 600;
            color: #333;
        }

        .grand-total {
            border-top: 1px solid #741212;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 1.1rem;
            color: #741212;
            font-weight: 700;
        }

        .total-section {
            background: rgba(116, 18, 18, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-label {
            font-weight: 600;
            color: #555;
        }

        .total-value {
            font-weight: 600;
            color: #333;
        }

        .grand-total {
            border-top: 1px solid #741212;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 1.1rem;
            color: #741212;
            font-weight: 700;
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
            display: inline-block;
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

        .status-canceled {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .items-table th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #741212;
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            font-size: 0.95rem;
            border-bottom: 2px solid #741212;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        .items-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .payment-icon {
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }

        .payment-icon.bri { color: #003d82; }
        .payment-icon.bni { color: #f57c00; }
        .payment-icon.gopay { color: #00aa13; }
        .payment-icon.shopeepay { color: #ee4d2d; }

        .payment-proof {
            max-width: 300px;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-proof:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .btn-back:hover {
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .btn-complete {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }

        .btn-complete:hover {
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
            color: white;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .btn-cancel:hover {
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            color: white;
        }

        .order-id {
            font-weight: 700;
            color: #741212;
            font-size: 1.2rem;
        }

        .total-amount {
            font-weight: 700;
            color: #28a745;
            font-size: 1.2rem;
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

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header {
                padding: 25px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }

            .detail-label {
                width: auto;
                font-weight: 700;
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

        .no-payment {
            color: #999;
            font-style: italic;
            padding: 20px;
            text-align: center;
            background: rgba(108, 117, 125, 0.1);
            border-radius: 8px;
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
                <li><a href="pesanan.php" class="active">
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
            <h1>Detail Pesanan</h1>
            <p>Informasi lengkap pesanan dan status pembayaran pelanggan</p>
        </div>

        <div class="detail-grid">
            <!-- Informasi Pesanan -->
            <div class="detail-card">
                <h3><i class="fas fa-receipt"></i> Informasi Pesanan</h3>
                
                <div class="detail-row">
                    <div class="detail-label">ID Pesanan:</div>
                    <div class="detail-value">
                        <span class="order-id">#<?php echo str_pad($pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value">
                        <?php 
                        $status_class = '';
                        if($pesanan['status'] == 'Completed') $status_class = 'status-completed';
                        elseif($pesanan['status'] == 'Pending') $status_class = 'status-pending';
                        else $status_class = 'status-canceled';
                        ?>
                        <span class="status-badge <?php echo $status_class; ?>">
                            <?php echo $pesanan['status']; ?>
                        </span>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Tanggal Pesan:</div>
                    <div class="detail-value"><?php echo date('d M Y H:i', strtotime($pesanan['tgl_pesan'])); ?></div>
                </div>
                
                <div class="total-section">
                    <div class="total-row">
                        <span class="total-label">Total Pembayaran:</span>
                        <span class="total-value">Rp <?php echo number_format($total_produk, 0, ',', '.'); ?></span>
                    </div>
                    
                    <div class="total-row">
                        <span class="total-label">Ongkos Kirim:</span>
                        <span class="total-value">Rp <?php echo number_format($pesanan['tarif'], 0, ',', '.'); ?></span>
                    </div>
                    
                    <div class="total-row grand-total">
                        <span>Total Pembayaran:</span>
                        <span>Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></span>
                    </div>
                </div>
                
            </div>

            <!-- Informasi Pelanggan -->
            <div class="detail-card">
                <h3><i class="fas fa-user"></i> Informasi Pelanggan</h3>
                
                <div class="detail-row">
                    <div class="detail-label">Nama:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($pesanan['nama']); ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($pesanan['email']); ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">No. HP:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($pesanan['no_hp']); ?></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Alamat:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($pesanan['alamat']); ?></div>
                </div>
            </div>
        </div>

        <!-- Item Pesanan -->
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> Item Pesanan</h2>
            </div>
            <div class="section-content">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-shopping-bag"></i> Nama Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(trim($item)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <?php if($pembayaran): ?>
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-credit-card"></i> Informasi Pembayaran</h2>
            </div>
            <div class="section-content">
                <div class="detail-grid">
                    <div class="detail-card">
                        <h3><i class="fas fa-money-bill-wave"></i> Detail Pembayaran</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Metode:</div>
                            <div class="detail-value">
                                <div class="payment-method">
                                    <?php 
                                    $method = $pembayaran['pembayaran'];
                                    $icon = '';
                                    
                                    switch($method) {
                                        case 'BRI':
                                            $icon = '<i class="fas fa-university payment-icon bri"></i>';
                                            break;
                                        case 'BNI':
                                            $icon = '<i class="fas fa-university payment-icon bni"></i>';
                                            break;
                                        case 'Gopay':
                                            $icon = '<i class="fab fa-google-wallet payment-icon gopay"></i>';
                                            break;
                                        case 'ShopeePay':
                                            $icon = '<i class="fas fa-wallet payment-icon shopeepay"></i>';
                                            break;
                                        default:
                                            $icon = '<i class="fas fa-money-bill-wave payment-icon"></i>';
                                    }
                                    
                                    echo $icon . ' ' . $method;
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Tanggal:</div>
                            <div class="detail-value"><?php echo date('d M Y H:i', strtotime($pembayaran['tgl_pesan'])); ?></div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Total Dibayar:</div>
                            <div class="detail-value">
                                <span class="total-amount">Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h3><i class="fas fa-receipt"></i> Bukti Pembayaran</h3>
                        <?php if(!empty($pembayaran['bukti_bayar'])): ?>
                            <img src="../<?php echo $pembayaran['bukti_bayar']; ?>" 
                                 alt="Bukti Pembayaran" 
                                 class="payment-proof"
                                 onclick="window.open(this.src, '_blank')">
                        <?php else: ?>
                            <div class="no-payment">
                                <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                                <p>Belum ada bukti pembayaran yang diunggah</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="pesanan.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
            
            <?php if($pesanan['status'] == 'Pending'): ?>
            <a href="proses_pesanan.php?action=complete&id=<?php echo $pesanan['id_pesanan']; ?>" 
               class="btn btn-complete" 
               onclick="return confirm('Yakin ingin menandai pesanan ini sebagai selesai?')">
                <i class="fas fa-check"></i> Tandai Selesai
            </a>
            <a href="proses_pesanan.php?action=cancel&id=<?php echo $pesanan['id_pesanan']; ?>" 
               class="btn btn-cancel" 
               onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                <i class="fas fa-times"></i> Batalkan Pesanan
            </a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>