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
          <a href="cart2.php"><i class='bx bx-cart'></i><span id="cart-count">0</span></a>
          <a href="user.php"><i class='bx bx-user-circle'></i></a>
        </div>
      </div>
          
        <!-- membuat sidebar(navigasi samping) -->
      <div class="sidebar" style="gap:10px;">
        <div class="logo">
          <i class='bx bx-menu menu-icon'></i>
          <span class="logo-name">MEIJIN MEALS</span>
        </div>

        <div class="sidebar-content ">
          <ul class="lists">
            <li class="list">
              <a href="index.php" class="nav-link">
                <i class="bi bi-house-fill" style=" margin-right: 10px;"></i>
                <span class="link">Home</span>
              </a>
            </li>

            <li class="list">
              <a href="about-us.php" class="nav-link">
                <i class="bi bi-info-circle-fill" style=" margin-right: 10px;"></i>
                <span class="link">About Us</span>
              </a>
            </li>

            <li class="list">
              <details class="dropdown-detail">
                <summary class="nav-link">
                  <i class="bi bi-caret-down-fill" style=" margin-right: 10px;"></i>
                  <span class="bi link">Menu</span>
                </summary>
                <div class="dropdown-content">
                  <a href="ramen_menu.php" class="nav-link"><span class="link">🍜 Ramen</span></a>
                  <a href="rice_menu.php" class="nav-link"><span class="link">🍚 Rice</span></a>
                  <a href="sushi_menu.php" class="nav-link"><span class="link">🍣 Sushi</span></a>
                  <a href="tempura_menu.php" class="nav-link"><span class="link">🍤 Tempura</span></a>
                  <a href="udon_menu.php" class="nav-link"><span class="link">🥢 Udon</span></a>
                </div>
              </details>
            </li>

            <li class="list">
              <a href="contact-us.php" class="nav-link">
                <i class="bi bi-people-fill" style=" margin-right: 10px;"></i>
                <span class="link">Contact Us</span>
              </a>
            </li>


            <li class="list">
              <a href="order.php" class="nav-link">
                <i class="bi bi-bag-fill" style=" margin-right: 10px;"></i>
                <span class="link">My Order</span>
              </a>
            </li>

          </ul>
        </div>

      </div>
    </div>
</nav>

    <div class="container">
        <div class="abt" style="font-family:'Unbounded';">
            <div class="text">
                <h1 style="margin-top:70px; background-color:#811A1A; height:60px; text-align:center; color:white; font-size:37px;">About US</h1>
                <hr style="all:unset; display:block; margin-button:8px; height:9px; background-color:#811A1A;"> <br>
            </div>

        
            <!-- konten gambar sebelah kiri -->
            <div class="konten kiri" style="font-size:;">
                <div class="img-abt">
                    <img src="asset/ramen-about.jpeg" alt="" height="430px" width="400px">
                </div>
                <div class="text-abt">
                    <h1>Ramen. Udon. Rice. Tempura. Sushi. Love.</h1><br>
                    <p style>Kami adalah Meijin Meals, toko makanan Jepang yang menyajikan berbagai hidangan otentik seperti ramen, udon, nasi, tempura, dan sushi. <br>
                    Semua resep yang digunakan adalah resep asli dari Jepang, dimasak dengan menggunakan bahan-bahan berkualitas dan alami, serta diproses di setiap outlet dengan teknik khusus dari Jepang yang dikendalikan dengan standar jaminan kualitas yang ketat.</p>
                </div>
            </div>

            <!-- konten gambar sebelah -->
            <div class="konten kanan">
                <div class="text-abt" style="margin-left:29px;">
                    <h1>We Bring Smiles To Everyone With Fresh Handmade Deliciousness</h1><br>
                    <p>Kami ingin berbagi pengalaman kuliner yang menarik dan memuaskan. Nikmati "pengalaman makanan yang menggembirakan" dari "hidangan udon dan ramen kami yang lezat dan segar". Kami hadir untuk membawa senyuman bagi banyak orang dengan pengalaman yang menggembirakan. Harapan kami adalah agar Meijin Meals dapat diidentifikasi oleh komitmen ini.</p>
                </div>
                <div class="img-abt">
                    <img src="asset/udon-about.jpeg" alt="" height="430px" width="400px">
                </div>
            </div>

            <!-- konten gambar sebelah kiri -->
            <div class="konten kiri">
                <div class="img-abt">
                    <img src="asset/sushi-about.jpeg" alt="" height="430px" width="400px">
                </div>
                <div class="text-abt">
                    <h1>Ramen. Udon. Rice. Tempura. Sushi. Love.</h1><br>
                    <p>Kami adalah Meijin Meals, toko makanan Jepang yang menyajikan berbagai hidangan otentik seperti ramen, udon, nasi, tempura, dan sushi. <br>
                    Semua resep yang digunakan adalah resep asli dari Jepang, dimasak dengan menggunakan bahan-bahan berkualitas dan alami, serta diproses di setiap outlet dengan teknik khusus dari Jepang yang dikendalikan dengan standar jaminan kualitas yang ketat.</p>
                </div>
            </div>
        </div>
    </div>
    
    <?php
  include "footer-red copy.html";
  ?>

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
</body>
</html>
