<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    die("Belum login. Session id_user tidak ditemukan.");
}

include "koneksi.php";

$id_user = $_SESSION['id_user'];

// $stmt = $koneksi->prepare("SELECT users.nama, users.email FROM users on users.id_user = contact_us.id_user WHERE id_user = '$id_user'");
$stmt = $koneksi->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$query = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="about-us.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Font GOOGLE -->
        <link href='https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap' rel='stylesheet' >

        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

        <!-- icon atas -->
        <link rel="shortcut icon" type="image/png/jpg" href="asset/icon putih meijin.png">
        <title>Meijin Meals</title>

 <style>
@import url('https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.logo {
    font-family: "Unbounded", sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
  }
  
  body{
    background: #ffffff;
    min-height: 100vh;
    position: relative;
  }
  
  .atas{
    display: flex;
    margin-top:17px;
  }

  .user-cart {
    margin-left:1140px;
    display: flex;
    gap: 8px;
  }

  .user-cart i {
    font-size: 30px;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .user-cart i:hover {
    color: #811A1A;
    transform: scale(1.1);
  }

  .side{
    position: fixed;
  }

  nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 70px;
    width: 100%;
    display: flex;
    align-items: center;
    background: rgb(255, 255, 255);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    z-index: 80; /*lapisan*/
  }

  nav .logo{
    display: flex;
    align-items: center;
    margin: 0 24px;
  }

  .logo .menu-icon{
    color: #333;
    font-size: 24px;
    margin-right: 14px;
    cursor: pointer;
  }

  .logo .logo-name{
    color: #333;
    font-size: 20px;
    font-weight: 500;
  }

  nav .sidebar{
    position: fixed;
    top: 0;
    left: -100%;
    height: 100%;
    width: 260px;
    padding: 20px 0;
    background-color: #ffffff !important; 
    backdrop-filter: none !important; 
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); 
    transition: all 0.5s ease;
    z-index: 100; 
}

nav .sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ffffff;
    z-index: -1;
}

  nav.open .sidebar{
    left: 0;
  }

 .sidebar .sidebar-content{
    display: flex;
    height: 100%;
    flex-direction: column;
    justify-content: space-between;
    padding: 30px 16px;
    background-color: transparent;
    position: relative;
    z-index: 2;
}

  .sidebar-content .list{
    list-style: none;
  }
  
  .list .nav-link{
    display: flex;
    align-items: center;
    margin: 8px 0;
    padding: 14px 12px;
    border-radius: 8px;
    text-decoration: none;
  }

  .lists .nav-link:hover{
    background-color: #811A1A;
  }

  .nav-link .link{
    font-family: "Trispace", sans-serif;
    font-size: 22px;
    color: black;
    font-weight: 400;
  }

 .lists .nav-link:hover .link{
    color: white;
  }

  .overlay{
    position: fixed;
    top: 0;
    left: -100%;
    height: 1000vh;
    width: 200%;
    opacity: 0;
    pointer-events: none;
    transition: all 0.5s ease;
  }

  nav.open ~ .overlay{
    opacity: 1;
    left: 260px;
    pointer-events: auto;
  }

  .layout {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .imgbg {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
    margin-top: 70px;
  }

  .imgbg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(129, 26, 26, 0.8), rgba(139, 11, 11, 0.6));
    z-index: 1;
  }

  .imgbg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .imgbg .text-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    color: white;
    text-align: center;
  }

  .text-container h1{
    font-size: 80px;
    color: white;
    font-family: 'Unbounded', sans-serif;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    animation: fadeInUp 1s ease-out;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translate(-50%, -30%);
    }
    to {
      opacity: 1;
      transform: translate(-50%, -50%);
    }
  }

  .container {
    max-width: 1400px;
    margin: 80px auto;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 50px;
    display: flex;
    gap: 60px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
  }

  .container::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 248, 230, 0.3) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
    pointer-events: none;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
  }

  .left, .right {
    flex: 1;
    position: relative;
    z-index: 2;
  }

  .left h2 {
    color: #333;
    font-weight: bold;
    font-size: 36px;
    margin-bottom: 20px;
    margin-top: 0;
    font-family: "Jockey One", cursive;
    background: linear-gradient(45deg, #811A1A, #D63031);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .left p {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.8;
    font-family: "Trispace", sans-serif;
  }

  .right{
    color: #333;
    margin-top: 0;
  }

  .right label{
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
    font-family: "Trispace", sans-serif;
  }

  .jam {
    background: linear-gradient(135deg, #811A1A, #D63031);
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin: 25px 0;
    box-shadow: 0 8px 25px rgba(129, 26, 26, 0.3);
  }

  .jam span {
    color: #FFE5B4;
    font-weight: bold;
    font-size: 20px;
  }

  .contact {
    background: rgba(255, 248, 230, 0.8);
    padding: 25px;
    border-radius: 15px;
    margin: 25px 0;
    border-left: 5px solid #811A1A;
  }

  .contact p {
    color: #333;
    display: flex;
    align-items: center;
    margin: 10px 0;
    font-size: 16px;
  }

  .contact span i{
    font-size:22px;
  }

  .contact a {
    color: #811A1A;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .contact a:hover {
    color: #D63031;
  }

  .loc {
    margin-top: 30px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }

  .loc iframe {
    border-radius: 15px;
    transition: transform 0.3s ease;
  }

  .loc:hover iframe {
    transform: scale(1.02);
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  input, textarea {
    padding: 15px 20px;
    border: 2px solid #E0E0E0;
    border-radius: 12px;
    font-size: 16px;
    font-family: "Trispace", sans-serif;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
  }

  input:focus, textarea:focus {
    outline: none;
    border-color: #811A1A;
    box-shadow: 0 0 0 3px rgba(129, 26, 26, 0.1);
    transform: translateY(-2px);
  }

  textarea {
    height: 140px;
    resize: vertical;
  }

  .row {
    display: flex;
    gap: 20px;
  }

  .half {
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .half span {
    padding: 15px 20px;
    background: linear-gradient(135deg, #FFF8E6, #FFE5B4);
    border: 2px solid #FFEAA7;
    border-radius: 12px;
    font-weight: 600;
    color: #333;
  }

  .btn-send {
    width: 120px;
    height: 50px;
    border: none;
    background: linear-gradient(135deg, #811A1A, #D63031);
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(129, 26, 26, 0.3);
    align-self: flex-start;
  }

  .btn-send:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(129, 26, 26, 0.4);
    background: linear-gradient(135deg, #D63031, #811A1A);
  }

  .btn-send i{
    color: white;
    font-size: 20px;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      margin: 40px 20px;
      padding: 30px;
      gap: 40px;
    }
    
    .text-container h1 {
      font-size: 50px;
    }
    
    .row {
      flex-direction: column;
      gap: 15px;
    }
    
    .user-cart {
      margin-left: auto;
    }
    
    .loc iframe {
      width: 100%;
      height: 200px;
    }
  }

  /* Animation untuk form elements */
  .right > * {
    animation: slideInRight 0.8s ease-out;
    animation-fill-mode: both;
  }

  .right > *:nth-child(1) { animation-delay: 0.1s; }
  .right > *:nth-child(2) { animation-delay: 0.2s; }
  .right > *:nth-child(3) { animation-delay: 0.3s; }
  .right > *:nth-child(4) { animation-delay: 0.4s; }
  .right > *:nth-child(5) { animation-delay: 0.5s; }
  .right > *:nth-child(6) { animation-delay: 0.6s; }

  @keyframes slideInRight {
    from {
      opacity: 0;
      transform: translateX(30px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .left > * {
    animation: slideInLeft 0.8s ease-out;
    animation-fill-mode: both;
  }

  .left > *:nth-child(1) { animation-delay: 0.1s; }
  .left > *:nth-child(2) { animation-delay: 0.2s; }
  .left > *:nth-child(3) { animation-delay: 0.3s; }
  .left > *:nth-child(4) { animation-delay: 0.4s; }
  .left > *:nth-child(5) { animation-delay: 0.5s; }
  .left > *:nth-child(6) { animation-delay: 0.6s; }

  @keyframes slideInLeft {
    from {
      opacity: 0;
      transform: translateX(-30px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
    </style>
</head>

<body>

<nav>

    <div class="side sticky-top">

      <div class="atas" style="margin-bottom:17px;">
        <div class="logo">
            <i class='bx bx-menu menu-icon'></i>
            <span class="logo-name">MEIJIN MEALS</span>
        </div> 
        <div class="user-cart">
            <a href="cart2.php"><i class='bx bx-cart'></i></a>
            <a href="user.php"><i class='bx bx-user-circle'></i></a>
          </div>
      </div>

<script>
function updateCartCount() {
    fetch('get_cart_count.php')
        .then(res => res.text())
        .then(count => {
            document.getElementById('cart-count').textContent = count;
        });
}

document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
          
        <!-- membuat sidebar(navigasi samping) -->
      <div class="sidebar">
        <div class="logo">
          <i class='bx bx-menu menu-icon'></i>
          <span class="logo-name">MEIJIN MEALS</span>
        </div>

        <div class="sidebar-content ">
          <ul class="lists">
            <li class="list">
              <a href="index.php" class="nav-link">
                <span class="link">Home</span>
              </a>
            </li>

            <li class="list">
              <a href="about-us.php" class="nav-link">
                <span class="link">About Us</span>
              </a>
            </li>

            <li class="list">
              <a href="ramen_menu.php" class="nav-link">
                <span class="link">Menu</span>
              </a>
            </li>

            <li class="list">
              <a href="contact-us.php" class="nav-link">
                <span class="link">Contact Us</span>
              </a>
            </li>


            <li class="list">
              <a href="order.php" class="nav-link">
                <span class="link">My Order</span>
              </a>
            </li>

          </ul>
        </div>

      </div>
    </div>
  </nav>

    <!-- <div class="layout"> -->
            <div class="imgbg">
              <img src="asset/pattern.jpg" alt="background image"  height="480px" width="1521px">
              <div class="overlay"></div>
              <div class="text-container">
                <h1>Contact Us</h1>
              </div>
            </div>

        <div class="container">
            <div class="left">
                <h2>Give Us Your Awesome Feedback</h2>
                <p>
                    Kami selalu berusaha memberikan yang terbaik untuk Anda, <br>
                    kami sangat menghargai masukan Anda tentang apa pun.
                </p><br>
                <p class="jam">
                    <span>Senin - Minggu </span><br/>
                    <span>10:00 - 22:00 WIB</span>
                </p>
                <p>
                    Hubungi kami atau tinggalkan pertanyaan yang belum terjawab di formulir. <br>Kami akan segera menanggapi Anda!
                </p>
                <div class="contact">
                    <p><a href="https://wa.me/6281215472082">+62 812-1547-2082 (amie)</a></p>
                    <p><a href="https://wa.me/6285727047757">+62 857-2704-7757(ssa) </a></p>
                     <span><i class="bi bi-instagram"></i> @meijin_meals</span><br>
                </div>
                <div class="loc">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3415.619103852259!2d109.34410847430001!3d-7.403735972902323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6559b9ff8d3795%3A0xa58daaef273f4e44!2sSMK%20Negeri%201%20Purbalingga!5e1!3m2!1sid!2sid!4v1746081887875!5m2!1sid!2sid" width="500" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

                <div class="right">
                  <?php while($users = mysqli_fetch_assoc($query)){?>
                    <form action="contact_proses.php" method="POST">
                        <input type="hidden" name="id_user" value="<?= $users['id_user']; ?>">
                        <input type="hidden" name="name" value="<?= $users['nama']; ?>">
                        <input type="hidden" name="email" value="<?= $users['email']; ?>">


                        <label for="">Subject:</label>
                        <input type="text" name="subject" placeholder="Subject" required>

                        <div class="row">
                            <div class="half">
                                <label for="">Name:</label>
                                <span><?= $users['nama']; ?></span>
                                <!-- <input type="text" name="name" placeholder="Name" required> -->
                            </div>
                            <div class="half">
                                <label for="">Email:</label>
                                <span><?= $users['email']; ?></span>
                                <!-- <input type="email" name="email" placeholder="name@example.com" required> -->
                            </div>
                        </div>

                        <label for="">Message:</label>
                        <textarea name="message" id="" cols="30" rows="10" placeholder="Message"></textarea>
                                
                        <button type="submit" class="btn-send"><i class='bx bx-send'></i></button>
                    </form>
                  <?php }?>
                </div>
        </div>
    </div>  
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

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

              overlay.addEventListener("click",() => {
                navBar.classList.remove("open");
              })
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
</body>
</html>