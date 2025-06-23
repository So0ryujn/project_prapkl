<?php
include "koneksi.php";
session_start();

// Cek login
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$query_kategori = mysqli_query($koneksi, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Tambah Admin Baru - Meijin Meals</title>
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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
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

        .breadcrumb {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border: 1px solid rgba(116, 18, 18, 0.1);
        }

        .breadcrumb a {
            color: #741212;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #8B1538;
            text-decoration: underline;
        }

        .breadcrumb i {
            margin: 0 10px;
            color: #999;
        }

        .breadcrumb .current {
            color: #666;
            font-weight: 500;
        }

        .form-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid rgba(116, 18, 18, 0.1);
        }

        .form-header {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        }

        .form-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .form-header i {
            margin-right: 10px;
        }

        .form-body {
            padding: 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #741212;
            font-size: 1rem;
            position: relative;
        }

        .form-group label i {
            margin-right: 8px;
            color: #8B1538;
        }

        .form-group label .required {
            color: #e74c3c;
            margin-left: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #741212;
            box-shadow: 0 4px 15px rgba(116, 18, 18, 0.2);
            transform: translateY(-2px);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 30px;
            border-top: 2px solid #e9ecef;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
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
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .alert {
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid;
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-error {
            color: #721c24;
            border-left-color: #dc3545;
        }

        .alert i {
            margin-right: 10px;
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

            .page-header h1 {
                font-size: 2rem;
            }

            .page-header {
                padding: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-body {
                padding: 30px 25px;
            }

            .form-actions {
                flex-direction: column;
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

        /* Form Animation */
        .form-group {
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
            <h1><i class="fas fa-user-plus"></i> Tambah Admin Baru</h1>
            <p>Tambahkan admin baru ke dalam sistem Meijin Meals</p>
        </div>

        <div class="breadcrumb">
            <a href="akun_admin.php"><i class="fas fa-user-shield"></i> Kelola Admin</a>
            <i class="fas fa-chevron-right"></i>
            <span class="current">Tambah Admin Baru</span>
        </div>

        <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Error!</strong> <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
        <?php endif; ?>
        
        <div class="form-container">
            <div class="form-header">
                <h2><i class="fas fa-user-cog"></i> Informasi Admin</h2>
            </div>
            
            <div class="form-body">
                <form action="proses_tambah_admin.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="username">
                                <i class="fas fa-user"></i> Username <span class="required">*</span>
                            </label>
                            <input type="text" name="username" id="username" required 
                                   placeholder="Masukkan username admin">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                            </label>
                            <input type="email" name="email" id="email" required 
                                   placeholder="Masukkan email admin">
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password <span class="required">*</span>
                        </label>
                        <input type="password" name="password" id="password" required 
                               placeholder="Masukkan password admin">
                    </div>
                    
                    <div class="form-actions">
                        <a href="akun_admin.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!username || !email || !password) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }

            return true;
        });

        // Password strength indicator (optional enhancement)
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = {
                weak: password.length < 6,
                medium: password.length >= 6 && password.length < 12,
                strong: password.length >= 12 && /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)
            };
            
            // You can add visual feedback here if needed
        });
    </script>
</body>
</html>