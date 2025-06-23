<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
    <div style="color: red; text-align: center; margin-top: 90px;">
        Username atau password salah.
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meijin Meals</title>
  <link rel="shortcut icon" href="asset/icon putih meijin.png">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #811a1a;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      overflow-x: hidden;
    }

    .wrapper {
      width: 450px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 25px;
      backdrop-filter: blur(20px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      margin-top: 100px;
      padding: 50px 40px;
      animation: slideUp 0.8s ease-out;
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

    h2 {
      font-family: "Jockey One", sans-serif;
      font-size: 48px;
      text-align: center;
      margin-bottom: 40px;
      color: white;
      letter-spacing: 3px;
      text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    .input-box {
      position: relative;
      margin: 25px 0;
    }

    .input-box input {
      width: 100%;
      padding: 15px 20px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 15px;
      color: white;
      font-size: 16px;
      font-family: "Jomolhari", sans-serif;
      outline: none;
      backdrop-filter: blur(10px);
    }

    .input-box input:focus {
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
    }

    .input-box input:focus ~ label,
    .input-box input:valid ~ label {
      top: -10px;
      left: 15px;
      font-size: 14px;
      color: white;
      background: #811a1a;
      padding: 2px 8px;
      border-radius: 5px;
    }

    .btn {
      width: 100%;
      height: 55px;
      background: #fff;
      border: none;
      border-radius: 15px;
      font-size: 18px;
      color: #811a1a;
      font-family: "Jockey One", sans-serif;
      font-weight: 600;
      letter-spacing: 1px;
      margin: 20px 0;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(184, 120, 74, 0.3);
    }

    .btn:hover {
      background: #811a1a;
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(184, 120, 74, 0.4);
    }

    .sign-inBack {
      text-align: center;
      font-family: "Jomolhari", sans-serif;
      font-size: 15px;
      color: rgba(255, 255, 255, 0.8);
    }

    .sign-inBack a {
      color: rgb(97, 185, 244);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .sign-inBack a:hover {
      color: rgb(44, 120, 171);
      text-decoration: underline;
      text-shadow: 0 0 10px rgba(22, 74, 109, 0.87);
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>LOGIN</h2>
    <form action="proses_login.php" method="post">
      <div class="input-box">
        <input type="text" name="username" required>
        <label for="">Username</label>
      </div>
      <div class="input-box">
        <input type="password" name="password" required>
        <label for="">Password</label>
      </div>
      <button type="submit" class="btn">SUBMIT</button>
      <div class="sign-inBack">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>