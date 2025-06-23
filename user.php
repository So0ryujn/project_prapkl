<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION['id_user'])) {
    die("Belum login. Session id_user tidak ditemukan.");
}
include "koneksi.php";

$id_user = $_SESSION['id_user'];

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Font GOOGLE -->
    <link href='https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap' rel='stylesheet' >

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <!-- Icon Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=settings" />

     <!-- icon atas -->
     <link rel="shortcut icon" type="image/png/jpg" href="asset/icon meijin.png">
    <title>Meijin Meals</title>

    <link rel="stylesheet" href="user.css">

</head>
<body style="background:#811a1a;">
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
        <div class="profile-container">
            <?php while($users = mysqli_fetch_assoc ($query)) { ?>
                <div class="img-profile">
                    <img id="preview" class="profile" src="asset/fp try.jpg" alt="Profile Image" style="box-shadow: 0 0 2px black;">
                    <center><p class="usn-user"><?= $users['username']; ?></p></center>
                    
                </div>
                
                <div class="container-text">
                    <div class="data">
                        <div class="data-user nama">
                            <span>nama:</span>
                            <span><?= $users['nama']; ?></span>
                        </div><br>
                        <div class="data-user email">
                            <span>email:</span>
                            <span><?= $users['email']; ?></span>
                        </div><br>
                        <div class="data-user tlp">
                            <span>ho hp:</span>
                            <span><?= $users['no_hp']; ?></span>
                        </div><br>
                        <div class="data-user alamat">
                            <span>alamat:</span>
                            <span><?= $users['alamat']; ?></span>
                        </div>
                    </div>
                <?php } ?>
               <hr style="all:unset; display:block; height: 3px; background-color: #811A1A; margin-top: 8px;">
                
                    <div class="action-buttons">
                        <a href="settings.php" class="btn-icon">
                            <span class="material-symbols-outlined">settings</span>
                        </a>
                        <a href="order.php" class="btn-text" style="font-family:'Unbounded';">
                            My Order
                        </a>
                        <a href="logout.php" class="btn-text" id="logout-btn" style="font-family:'Unbounded';">Logout</a>
                        
                        <!-- SweetAlert2 -->
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        document.getElementById('logout-btn').addEventListener('click', function (event) {
                        event.preventDefault(); // Cegah redirect langsung
                        Swal.fire({
                            title: "Yakin mau logout?",
                            text: "Kamu akan keluar dari website ini, kalau mau masuk login lagi yaaaaa!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            cancelButtonText: "Batal",
                            confirmButtonText: "Okee"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            // user klik "Ya, logout!", baru redirect
                            window.location.href = this.href;
                            }
                        });
                        });
                        </script>

                    </div>
            </div>
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

document.addEventListener("DOMContentLoaded", updateCartCount);
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