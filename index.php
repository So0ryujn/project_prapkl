<?php
include "koneksi.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Font GOOGLE -->
    <link href='https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap' rel='stylesheet' >
    <!-- icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=shopping_cart" />

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css' rel='stylesheet'>

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
    color: rgb(150, 34, 34);
    justify-content: center;
    align-items: center;
    background-size: cover;
    background-attachment: fixed;
    position: relative;
    background-position: center;
  }


  body.fade {
    opacity: 1;
    transition: opacity 0.5s ease;
  }
  
  body.fade-out {
    opacity: 0;
  }
  
  .atas{
    display: flex;
    justify-content: center;
    margin-top:17px;
  }

  .user-cart i{
    color: #333;
    font-size: 30px;
  }

  .user-cart i:hover{
    color: #811A1A;
  }

  .side{
    position: fixed;
  }

  .sidebar .sidebar-content i{
    font-size:19px; 
    color:#811a1a;
  }

  /* .sidebar .sidebar-content i:hover{
    color:#fff;
  } */
  
  nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 70px;
    width: 100%;
    display: flex;
    align-items: center;
    background: rgb(255, 255, 255);
    box-shadow: 0 0 1px black;
    z-index: 80; /*lapisan*/
  }

  nav .logo{
    display: flex;
    align-items: center;
    margin: 0 24px;
  }

   .logo-name {
    font-family: "Unbounded", sans-serif;
    font-size: 20px;
    color: #333;
  }

  .user-cart {
    margin-left:1140px;
    display: flex;
    gap: 8px;
  }

  .user-cart span{
    display:flex;
    width:20px;
    height:20px;
    background-color :red;
    justify-content:center;
    align-items:center;
    color:#fff;
    border-radius:50%;
    position:absolute;
    top: 50%;
 
  }

  .user-cart i {
    font-size: 30px;
    color: #333;
    cursor: pointer;
  }

  .user-cart i:hover {
    color: #811A1A;
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
    background-color: white;
    box-shadow: 0 5 10px black;
    transition: all 0.5s ease;
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

   .lists .nav-link:hover i{
    color:white;
   }

  .dropdown-detail {
  padding: 0;
  border-radius: 8px;
  margin: 8px 0;
}

.dropdown-detail summary {
  padding: 14px 12px;
  border-radius: 10px;
  background-color: transparent;
  color: black;
  cursor: pointer;
}

.dropdown-detail summary:hover {
  background-color: #811A1A;
  color: white;
}

.dropdown-detail[open] summary {
  background-color: #811A1A;
  color: white;
}

.dropdown-detail[open] summary .bi {
  color: white;
}


.dropdown-content {
  display: flex;
  flex-direction: column;
  padding-left: 16px;
}

.dropdown-content .nav-link {
  padding: 10px 0 10px 12px;
  font-size: 18px;
}

.dropdown-content .nav-link:hover {
  background-color: #f1f1f1;
  border-radius: 6px;
  color:black;
}

.dropdown-content .nav-link:hover .link {
  color:rgb(0, 0, 0);
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

  .side .sticky-top{
    display:flex;
    justify-content:space-beetween;
  }
  
.marquee-wrapper {
  width: 100%;
  overflow: hidden;
  background-color: #fffbe6;
  white-space: nowrap;
}

.marquee-content {
  display: inline-block;
  animation: scroll-left 27s linear infinite;
}

.marquee-text {
  display: inline-block;
  padding-right: 4rem;
  font-size: 30px;
  font-weight: 600;
  color: #d35400;
}

@keyframes scroll-left {
  from {
    transform: translateX(0%);
  }
  to {
    transform: translateX(-100%);
  }
}
  
 .img{
  object-fit: cover;
  height: 100vh;
  width: 100vw;
  margin-top: 2rem;
 }

 .img-geser{
  object-fit: cover;
  height: 100vh;
  width: 100vw;
 }

.menu-card {
  text-align: center;
  padding: 20px;
  border: none;
  border-radius: 10px;
  background: #FFF;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.menu-card:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.menu-icon {
  font-size: 40px;
  color: #d35400;
  margin-bottom: 10px;
}

.menu-img {
  width: 100%;
  max-width: 150px;
  border-radius: 50%;
  margin: 15px auto;
}

.menu-description {
  flex-grow: 1;
}

.about-us{
  display: flex;
  margin-bottom: 15px;
  gap:50px;
  background: #FFF;
}

.about p{
  font-family: 'trispace';
  font-size: 18px;
}
.about h1{
  font-family: 'Unbounded';
  font-size: 24px;
}

.about{
  justify-content: center;
  color: black;
  margin-left: 105px;
  margin-top:  90px; 
}

.about-btn{
  border: none;
  width: 120px;
  height: 40px;
  background: #811A1A;
  color: white;
  font-family: 'Unbounded';
}

.about-btn:hover{
  background: transparent;
  color: #811A1A;
}
.doc-img{
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
}
.doc-img:hover{
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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

  <!-- konten utama -->
  <div >
    <img src="asset/meijinbg dekstop.png" alt="" class="img">
  </div>

    <!-- Marquee -->
  <div class="marquee-wrapper">
    <div class="marquee-content">
      <span class="marquee-text">Nikmati Cita Rasa Jepang Dalam Setiap Suapan!</span>
      <span class="marquee-text">Nikmati Cita Rasa Jepang Dalam Setiap Suapan!</span>
      <span class="marquee-text">Nikmati Cita Rasa Jepang Dalam Setiap Suapan!</span>
      <span class="marquee-text">Nikmati Cita Rasa Jepang Dalam Setiap Suapan!</span>
      <span class="marquee-text">Nikmati Cita Rasa Jepang Dalam Setiap Suapan!</span>
    </div>
  </div>

    <!--slide  -->
  <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="asset/ramen dekstopbg.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="asset/sushi dekstopbg.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="asset/takoyaki dekstopbg.png" class="d-block w-100" alt="...">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="container py-5">
    <div class="row g-4 justify-content-center">

      <!-- Ramen -->
      <div class="col-md-4 col-sm-6 col-lg-2 d-flex">
        <a href="ramen_menu.php" class="menu-card">
          <div>
            <div class="menu-icon">🍜</div>
            <h5><strong>Ramen</strong></h5>
            <p class="text-muted menu-description">Mie kenyal, kuah gurih, dan topping komplet! Ramen kami cocok buat yang lagi butuh pelukan… dari makanan.</p>
          </div>
          <img src="asset/5.png" alt="Ramen" class="menu-img">
          <div class="orange-bottom"></div>
        </a>
      </div>

      <!-- Rice -->
      <div class="col-md-4 col-sm-6 col-lg-2 d-flex">
        <a href="rice_menu.php" class="menu-card">
          <div>
            <div class="menu-icon">🍚</div>
            <h5><strong>Rice</strong></h5>
            <p class="text-muted menu-description">Nasi hangat dengan aneka topping lezat. Solusi praktis saat lapar tapi pengen dimanjain.</p>
          </div>
          <img src="asset/4.png" alt="Rice" class="menu-img">
          <div class="orange-bottom"></div>
        </a>
      </div>

      <!-- Sushi -->
      <div class="col-md-4 col-sm-6 col-lg-2 d-flex">
        <a href="sushi_menu.php" class="menu-card">
          <div>
            <div class="menu-icon">🍣</div>
            <h5><strong>Sushi</strong></h5>
            <p class="text-muted menu-description">Nasi hangat dengan aneka topping lezat. Solusi praktis saat lapar tapi pengen dimanjain.</p>
          </div>
          <img src="asset/3.png" alt="Sushi" class="menu-img">
          <div class="orange-bottom"></div>
        </a>
      </div>

      <!-- Tempura -->
      <div class="col-md-4 col-sm-6 col-lg-2 d-flex">
        <a href="tempura_menu.php" class="menu-card">
          <div>
            <div class="menu-icon">🍤</div>
            <h5><strong>Tempura</strong></h5>
            <p class="text-muted menu-description">Gorengan ala Jepang yang renyah di luar, lembut di dalam. Udang dan sayur pun tampil elegan!</p>
          </div>
          <img src="asset/1.png" alt="Tempura" class="menu-img">
          <div class="orange-bottom"></div>
        </a>
      </div>

      <!-- Udon -->
      <div class="col-md-4 col-sm-6 col-lg-2 d-flex">
        <a href="udon_menu.php" class="menu-card">
          <div>
            <div class="menu-icon">🥢</div>
            <h5><strong>Udon</strong></h5>
            <p class="text-muted menu-description">Mie tebal nan empuk, disajikan hangat atau dingin. Udon tuh ibarat temen baik—selalu bikin nyaman.</p>
          </div>
          <img src="asset/2.png" alt="Udon" class="menu-img">
          <div class="orange-bottom"></div>
        </a>
      </div>

    </div>
  </div>

  <div class="about-us">
    <div class="about" style=" width:870px; margin-left:120px;">
      <h1>Ramen. Udon. Rice. Tempura. Sushi. Love.</h1><br>
      <p>Kami adalah Meijin Meals, toko makanan Jepang yang menyajikan berbagai hidangan otentik seperti ramen, udon, nasi, tempura, dan sushi. Semua resep yang digunakan adalah resep asli dari Jepang, dimasak dengan menggunakan bahan-bahan berkualitas dan alami, serta diproses di setiap outlet dengan teknik khusus dari Jepang yang dikendalikan dengan standar jaminan kualitas yang ketat.</p>
      <a href="about-us.php"><br><button class="about-btn">Read More</button></a>
    </div>
      <div class="img-about" style=" margin-right:95px;">
        <img src="asset/yuta_chef.png" alt="" height="490px" width="380px">
      </div>
  </div>

  <div class="documentation" style="display:flex; gap:8px; margin-bottom:20px; justify-content:center; align-items:center;">
    <img class="doc-img" src="asset/dokumentasi5.jpeg" alt="" width="220px" height="290px" style="border-radius:10px;">
    <img class="doc-img" src="asset/dream fiksss.jpg" alt="" width="450px" height="290px" style="border-radius:10px;">
    <img class="doc-img" src="asset/dokumentasi3.jpeg" alt="" width="250px" height="290px" style="border-radius:10px;">
    <img class="doc-img" src="asset/dokumentasi2.jpeg" alt="" width="300px" height="290px" style="border-radius:10px;">
    <img class="doc-img" src="asset/dokumentasi1.jpeg" alt="" width="230px" height="290px" style="border-radius:10px;">
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


  <?php
  include "footer-red copy.html";
  ?>
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