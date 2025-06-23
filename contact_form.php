<?php
include "koneksi.php";
session_start();

// Cek login admin
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Ambil semua pesan dari contact_form
$query = "SELECT cf.*, u.username 
          FROM contact_form cf
          LEFT JOIN users u ON cf.id_user = u.id_user
          ORDER BY cf.id_contactform DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Kotak Masuk - Meijin Meals</title>
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
            background: linear-gradient(90deg, transparent, rgba(116, 18, 18, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .action-bar:hover::before {
            left: 100%;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box input {
            padding: 12px 20px;
            width: 350px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-box input:focus {
            outline: none;
            border-color: #741212;
            box-shadow: 0 0 0 3px rgba(116, 18, 18, 0.1);
        }

        .search-box i {
            color: #741212;
            font-size: 1.2rem;
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

        .alert {
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
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
        
        .messages-container {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .message-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .message-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 18, 18, 0.02), transparent);
            transition: left 0.6s ease;
        }

        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #741212;
        }

        .message-card:hover::before {
            left: 100%;
        }
        
        .message-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        
        .message-subject {
            font-weight: 700;
            font-size: 1.3rem;
            color: #741212;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .message-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.9rem;
            color: #666;
            min-width: 250px;
        }

        .message-meta div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .message-meta i {
            width: 16px;
            text-align: center;
            color: #741212;
        }
        
        .message-body {
            padding: 25px;
            line-height: 1.8;
            color: #555;
            font-size: 1rem;
            background: white;
        }
        
        .message-actions {
            padding: 20px 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
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
        
        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        .btn-reply {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-reply:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 25px;
            opacity: 0.4;
            animation: pulse 2s infinite;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #741212;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 400;
            color: #999;
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
            }

            .search-box input {
                width: 100%;
            }

            .message-header {
                flex-direction: column;
                gap: 15px;
            }

            .message-meta {
                min-width: auto;
                width: 100%;
            }

            .message-actions {
                justify-content: center;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header {
                padding: 25px;
            }

            .messages-container {
                padding: 20px;
                max-height: none;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar,
        .messages-container::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track,
        .messages-container::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb,
        .messages-container::-webkit-scrollbar-thumb {
            background: rgba(116, 18, 18, 0.3);
            border-radius: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover,
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: rgba(116, 18, 18, 0.5);
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
                <li><a href="contact_form.php" class="active">
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
            <h1><i class="fas fa-envelope"></i> Kotak Masuk</h1>
            <p>Kelola pesan dan komunikasi dari pelanggan Meijin Meals</p>
        </div>

        <div class="action-bar">
            <div class="total-info">
                <i class="fas fa-info-circle"></i>
                <span>Total Pesan: <strong><?php echo mysqli_num_rows($result); ?></strong></span>
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari pesan berdasarkan nama, email, atau subjek..." id="searchInput">
            </div>
        </div>
        
        <?php if(isset($_GET['sukses'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Berhasil!</strong> Pesan berhasil <?php echo htmlspecialchars($_GET['sukses']); ?>!
        </div>
        <?php endif; ?>
        
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-inbox"></i> Daftar Pesan Masuk</h2>
            </div>
            
            <div class="messages-container">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($message = mysqli_fetch_assoc($result)): ?>
                    <div class="message-card">
                        <div class="message-header">
                            <div>
                                <div class="message-subject"><?php echo htmlspecialchars($message['subject']); ?></div>
                            </div>
                            <div class="message-meta">
                                <div>
                                    <i class="fas fa-user"></i>
                                    <span><?php echo $message['id_user'] ? htmlspecialchars($message['username']) : htmlspecialchars($message['name']); ?></span>
                                </div>
                                <div>
                                    <i class="fas fa-envelope"></i>
                                    <span><?php echo htmlspecialchars($message['email']); ?></span>
                                </div>
                                <div>
                                    <i class="fas fa-clock"></i>
                                    <span><?php echo date('d/m/Y H:i', strtotime($message['created_at'] ?? 'now')); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="message-body">
                            <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                        </div>
                        
                        <div class="message-actions">
                            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Re: <?php echo htmlspecialchars($message['subject']); ?>" class="btn btn-reply">
                                <i class="fas fa-reply"></i> Balas
                            </a>
                            <a href="delete_message.php?id=<?php echo $message['id_contactform']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Kotak Masuk Kosong</h3>
                    <p>Belum ada pesan yang masuk dari pelanggan</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Fungsi untuk search/filter pesan
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const messages = document.querySelectorAll('.message-card');
            
            messages.forEach(message => {
                const text = message.textContent.toLowerCase();
                if(text.includes(searchTerm)) {
                    message.style.display = 'block';
                } else {
                    message.style.display = 'none';
                }
            });
        });

        // Smooth scroll animation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>