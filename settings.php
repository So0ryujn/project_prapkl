<?php

session_start();

include "koneksi.php";

if(!isset($_SESSION['id_user'])) {
    header("location:login.php?pesan=LoginDulu");
    exit;
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT * FROM users WHERE id_user = '$id_user'";

$query = mysqli_query($koneksi, $sql);

while($users = mysqli_fetch_assoc($query)) :
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
    background-color: rgb(150, 34, 34);
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
    z-index: 80; /lapisan/
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
        /* MINIMALIST CONTAINER STYLES */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            margin-top: 70px;
            padding: 2rem;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .profile-title {
            font-family: "Unbounded", sans-serif;
            font-size: 1.8rem;
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-family: "Trispace", sans-serif;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.5rem;
            font-weight: 400;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: "Trispace", sans-serif;
            background: #fafafa;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #811a1a;
            background: white;
            box-shadow: 0 0 0 3px rgba(129, 26, 26, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #811a1a 0%, #a52828 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: "Trispace", sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(129, 26, 26, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .profile-card {
                padding: 2rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .user-cart {
                margin-left: auto;
                margin-right: 1rem;
            }
        }

        @media (max-width: 480px) {
            .profile-card {
                padding: 1.5rem;
            }
            
            .profile-title {
                font-size: 1.5rem;
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
        <div class="profile-card">
            <h2 class="profile-title">User Profile</h2>
            <form action="user_edit.php" method="POST">
                <input type="hidden" name="id_user" value="<?= $users['id_user'] ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?= $users['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Full Name</label>
                        <input type="text" name="nama" id="nama" value="<?= $users['nama'] ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $users['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Phone Number</label>
                        <input type="text" name="no_hp" id="no_hp" value="<?= $users['no_hp'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Address</label>
                    <textarea name="alamat" id="alamat" required><?= $users['alamat'] ?></textarea>
                </div>

                <input type="submit" value="Save Changes" class="submit-btn">
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
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php endwhile ?>