<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- Font GOOGLE -->
    <link href='https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap' rel='stylesheet' >

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  
   <!-- icon atas -->
    <link rel="shortcut icon" type="image/png/jpg" href="asset/icon meijin.png">
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
        background-color: #fffbe6;
        color: rgb(0, 0, 0);
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
    z-index: 80; 
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
    .img-circle{
      border-radius: 0 0 0 180px;
      height: 530px;
      width: 530px;

    } 
    .head-content{
      display: flex;
      margin-top: 80px;
      gap: 50px;
      font-family: "Trispace";
      color: #811A1A;
    } 
    .head-content .kanan{
      flex-direction: row-reverse;
    }
    .head-content .kiri{
      flex-direction: row;
      margin-top: 50px;
    }
    .text-after-head{
      font-family: "Trispace";
      font-size: 60px;
      color: #811A1A;
    }
    .faq_outer h4{
    font-size: 21px;
  }

  .faq_outer p{
    font-size: 19px;
  }

  .faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
    margin-left: 15px;
  }

  .faq-grid h4{
    color: #811A1A;
  }

  .detail .box{
    position: relative;
    overflow: hidden;
  }
  .faq_outer .detail{
    padding: 10px;
    background: #f7d9ac89;
    margin-bottom: 10px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 5px;
  }

  .faq_outer .info {
    padding: 10px;
    background: #f1c587c4;
    color: #811A1A;
    margin-top: 10px;
    cursor: auto;
    border-radius: 5px;
  }

  .faq-title {
    text-align: center;
    color: #811A1A;
    font-size: 36px;
    font-family: "Unbounded", sans-serif;
    margin-bottom: 30px;
    margin-top: 80px;
  }

  .content {
    position: relative;
    z-index: 2; /* Biar muncul di atas overlay */
    color: #811A1A;
    padding: 50px;
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

<div class="container">
  <div class="faq-content">
    <div class="head-content">
      <div class="text-head kiri">
        <span style="font-size: 52px;"><b>Ada yang ingin anda ketahui dari kami?</b></span><br>
        <span style="font-size: 34px;">Kami bisa memberikan jawabannya!</span>
      </div>

      <div class="img-head kanan">
        <img src="asset/dokumentasi1.jpeg" alt="" class="img-circle">
      </div>
    </div>
    <div class="text-after-head">
      <hr>
      <span ><center>--FAQ--</center></span>
    </div>
  </div>

  <div class="faq_outer" style="display:flex;">
    <div class="faq-grid">
      <div class="detail singkat box" >
        <h4>Apa Itu MEIJIN MEALS?</h4>
        <div class="info">
          <p>Meijin Meals adalah toko makanan Jepang yang menyajikan berbagai hidangan otentik seperti ramen, udon, nasi, tempura, dan sushi. Kami berkomitmen untuk menggunakan resep asli dari Jepang dengan bahan-bahan berkualitas tinggi.</p>
        </div>
      </div>

      <div class="detail jam box" >
        <h4>Jam Operasional MEIJIN MEALS?</h4>
          <div class="info">
            <p>Meijin Meals umumnya buka dari pukul 10:00 s/d 22:00 WIB.</p>
            <p>Hari libur nasional tetap buka, kecuali ada pemberitahuan khusus di media sosial kami.</p>
          </div>
      </div>

      <div class="detail bahan box" >
        <h4>Apakah MEIJIN MEALS memiliki sertifikasi halal?</h4>
        <div class="info">
          <p>Ya, semua bahan yang digunakan di Meijin Meals adalah bahan yang halal dan telah mendapatkan persetujuan dari LPPOM Majelis Ulama Indonesia (MUI).</p>
        </div>
      </div>

      <div class="detail pesan box" >
        <h4>Bagaimana cara melakukan pemesanan?</h4>
        <div class="info">
          <p>Pesan ramen halal favorit dari MEIJIN MEALS kini makin mudah. Cukup kunjungi website resmi kami, pilih menu, isi data pengiriman, dan lakukan pembayaran online. Praktis tanpa harus keluar rumah.</p>
        </div>
      </div>

      <div class="detail menuu" >
        <h4>Apakah ada menu spesial di MEIJIN MEALS?</h4>
        <div class="info">
          <p>Kami selalu memperbarui menu kami dengan hidangan spesial musiman dan penawaran menarik. Pastikan untuk memeriksa menu kami secara berkala di website atau sosial media kami untuk mendapatkan informasi terbaru.</p>
        </div>
      </div>

      <div class="detail menuu" >
        <h4>Apakah ramen di MEIJIN MEALS instan atau fresh?</h4>
        <div class="info">
          <p>Ramen kami dibuat fresh setiap hari dengan resep khas MEIJIN MEALS. Tidak menggunakan mie instan, dan kuahnya direbus dari kaldu asli selama berjam-jam untuk menghasilkan rasa autentik.</p>
        </div>
      </div>

      <div class="detail menuu" >
        <h4>Apakah MEIJIN MEALS menerima pre-order untuk acara atau catering?</h4>
        <div class="info">
          <p>Tentu saja! Kami melayani pesanan dalam jumlah besar untuk acara kantor, ulang tahun, dan event lainnya. Hubungi kami minimal H-4 untuk diskusi menu dan jumlah porsi.</p>
        </div>
      </div>          
    </div>
  </div>
  <hr>
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

<script>
  const iframe = document.getElementById('footer-frame');
  iframe.onload = () => {
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
  };
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
</body>
</html>