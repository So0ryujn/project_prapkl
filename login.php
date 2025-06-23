<?php
session_start();
include "koneksi.php";

if(isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard_admin.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hanya untuk demo, gunakan password_hash di production
    
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE user_admin = '$username' AND pass_admin = '$password'");
    
    if(mysqli_num_rows($query) == 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: dashboard_admin.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="../asset/icon putih meijin.png">
    <title>Login Admin - Meijin Meals</title>
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
        }

        .login-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            width: 380px;
            max-width: 90%;
            border: 1px solid rgba(116, 18, 18, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 18, 18, 0.05), transparent);
            transition: left 0.8s ease;
        }

        .login-container:hover::before {
            left: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .login-header .logo {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .login-header .logo img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid rgba(116, 18, 18, 0.2);
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.2);
        }

        .login-header .logo img:hover {
            transform: scale(1.1) rotate(5deg);
            border-color: #741212;
            box-shadow: 0 12px 35px rgba(116, 18, 18, 0.3);
        }

        .login-header h1 {
            color: #741212;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .login-header p {
            color: #666;
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        <?php if(isset($error)): ?>
        .error-message {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            margin-bottom: 25px;
            padding: 15px 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #f5c6cb;
            box-shadow: 0 4px 15px rgba(114, 28, 36, 0.1);
            position: relative;
            overflow: hidden;
        }

        .error-message::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: #721c24;
        }

        .error-message i {
            margin-right: 8px;
        }
        <?php endif; ?>

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #741212;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 15px 45px 15px 18px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-family: inherit;
            font-size: 15px;
            background-color: #ffffff;
            transition: all 0.3s ease;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #741212;
            box-shadow: 0 0 0 3px rgba(116, 18, 18, 0.1);
            transform: translateY(-2px);
        }

        .form-group .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #741212;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus + .input-icon {
            transform: translateY(-50%) scale(1.1);
            color: #741212;
        }

        .btn-login {
            background: linear-gradient(135deg, #741212 0%, #8B1538 100%);
            color: #ffffff;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(116, 18, 18, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(116, 18, 18, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login i {
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(3px);
        }

        .additional-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .additional-links a {
            color: #741212;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid transparent;
        }

        .additional-links a:hover {
            color: #8B1538;
            background: rgba(116, 18, 18, 0.05);
            border-color: rgba(116, 18, 18, 0.1);
            transform: translateY(-2px);
        }

        .additional-links a i {
            margin-right: 6px;
            font-size: 12px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 30px 25px;
                width: 95%;
                border-radius: 15px;
            }

            .login-header h1 {
                font-size: 1.8rem;
            }

            .login-header .logo img {
                width: 70px;
                height: 70px;
            }

            .form-group input {
                padding: 16px 45px 16px 18px;
                font-size: 15px;
            }

            .btn-login {
                padding: 16px 25px;
                font-size: 15px;
            }
        }

        /* Loading animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .btn-login {
            background: linear-gradient(135deg, #666 0%, #888 100%);
        }

        /* Entrance animation */
        .login-container {
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <img src="../asset/icon meijin.png" alt="Meijin Logo">
            </div>
            <h1>Admin Portal</h1>
            <p>Masuk ke dashboard admin Meijin Meals</p>
        </div>
        
        <?php if(isset($error)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username
                </label>
                <div class="input-wrapper">
                    <input type="text" name="username" id="username" required placeholder="Masukkan username admin">
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" required placeholder="Masukkan password">
                    <i class="fas fa-lock input-icon"></i>
                </div>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="additional-links">
            <a href="../index.php">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.querySelector('.login-container').classList.add('loading');
        });

        // Auto focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });

        // Enter key navigation
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('password').focus();
            }
        });
    </script>
</body>
</html>