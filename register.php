<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png/jpg" href="asset/icon putih meijin.png">
    <title>Meijin Meals</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .logo {
            font-family: "Unbounded", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        
        body {
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #811a1a;
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }
        
        /* Modern wrapper design */
        .wrapper {
            position: relative;
            width: 450px;
            min-height: 650px;
            margin-top: 100px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            backdrop-filter: blur(20px);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
            z-index: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wrapper .form-box {
            width: 100%;
            padding: 50px 40px;
            position: relative;
            z-index: 2;
        }

        .form-box h2 {
            font-family: "Jockey One", sans-serif;
            font-size: 48px;
            color: white;
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            letter-spacing: 3px;
        }

        .input-box {
            position: relative;
            width: 100%;
            margin: 25px 0;
        }

        .input-box input,
        .input-box textarea {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            color: white;
            font-size: 16px;
            font-family: "Jomolhari", sans-serif;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .input-box textarea {
            min-height: 80px;
            resize: vertical;
            padding-top: 15px;
        }

        .input-box input:focus,
        .input-box textarea:focus {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            font-family: "Jockey One", sans-serif;
            pointer-events: none;
            transition: all 0.3s ease;
            background: transparent;
            padding: 0 5px;
        }

        .input-box textarea + label {
            top: 25px;
            transform: translateY(0);
        }

        .input-box input:focus ~ label,
        .input-box input:valid ~ label,
        .input-box textarea:focus ~ label,
        .input-box textarea:valid ~ label {
            top: -10px;
            left: 15px;
            font-size: 14px;
            color: white;
            transform: translateY(0);
            background: #811a1a;
            padding: 2px 8px;
            border-radius: 5px;
        }

        .input-box input::placeholder,
        .input-box textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn {
            width: 100%;
            height: 55px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            color: #811a1a;
            font-weight: 600;
            font-family: "Jockey One", sans-serif;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(184, 120, 74, 0.3);
            margin: 20px 0;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(184, 120, 74, 0.4);
            color:#fff;
            background:#811a1a;
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .sign-upBack {
            text-align: center;
            margin-top: 25px;
            font-family: "Jomolhari", sans-serif;
        }

        .sign-upBack p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
        }

        .sign-upBack a {
            color:rgb(97, 185, 244);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sign-upBack a:hover {
            color:rgb(44, 120, 171);
            text-decoration: underline;
            text-shadow: 0 0 10px rgba(22, 74, 109, 0.87);
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float-particle 8s infinite ease-in-out;
        }

        @keyframes float-particle {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            50% {
                transform: translateY(-100px) translateX(50px);
            }
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 6s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 7s; }

        /* Responsive design */
        @media (max-width: 480px) {
            .wrapper {
                width: 90%;
                margin: 80px 20px;
            }
            
            .wrapper .form-box {
                padding: 30px 25px;
            }
            
            .form-box h2 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating particles -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>


    <div class="wrapper">
        <div class="form-box sign-up">
            <h2>REGISTER</h2>
            <form action="proses_register.php" method="post">
                <div class="input-box">
                    <input type="text" name="username" required>
                    <label for="">Username</label>
                </div>
                <div class="input-box">
                    <input type="text" name="nama" required>
                    <label for="">Name</label>
                </div>
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label for="">Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                </div>
                <div class="input-box">
                    <input type="tel" name="no_hp" required>
                    <label for="">Nomor HP</label>
                </div>
                <div class="input-box">
                    <textarea name="alamat" required></textarea>
                    <label for="">Alamat</label>
                </div>
                <button type="submit" class="btn">SUBMIT</button>

                <div class="sign-upBack">
                    <p>Already have an account? <a href="login.php" class="sign-upLink">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <section class="overlay"></section>

    <script>
        const navBar = document.querySelector("nav"),
              menuBtns = document.querySelectorAll(".menu-icon"),
              overlay = document.querySelector(".overlay");
        
        menuBtns.forEach(menuBtn => {
            menuBtn.addEventListener("click", () => {
                navBar.classList.toggle("open")
            });
        });

        overlay.addEventListener("click", () => {
            navBar.classList.remove("open");
        });

        // Add interactive input focus effects
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>