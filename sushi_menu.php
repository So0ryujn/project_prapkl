<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$qry = $koneksi->query("SELECT 
        id_produk,
        nama_produk,
        harga_produk,
        foto_produk,
        deskripsi
    FROM produk
    WHERE id_kategori = 3
");
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

      .list-menu  span{
          margin-left: 30px;
          font-style: none;
          text-decoration: none;
      }

      .flip-card-container {
        perspective: 1000px;
        width: 18rem; /* lebar tiap card */
        margin-top: 30px;
        display: flex;
        flex-direction: column;
      }


      .flip-card {
        position: relative;
        width: 100%;
        min-height: 350px;
        transform-style: preserve-3d;
        transition: transform 0.8s;
      }

      .flip-card-front,
      .flip-card-back {
        position: absolute;
        width: 100%;
        min-height: 350px;
        backface-visibility: hidden;
        top: 0;
        left: 0;
      }


      .flip-card-back {
        width: 18rem;
        background: white;
        transform: rotateY(180deg);
        color: black;
      }

      .flip-card.flipped {
        transform: rotateY(180deg);
      }

      /* --- Overlay Deskripsi saat hover --- */
      .card-img {
        position: relative;
      }

      .card-img-top {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border-radius: 8px;
      }


      .img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5); /* transparan hitam */
        opacity: 0;
        transition: opacity 0.3s;
      }

      .card-img:hover .img-overlay {
        opacity: 1;
      }

      /* Tombol Deskripsi di tengah overlay */
      .show-desc-btn {
        z-index: 10;
      }

      /* Gaya harga */
      .card-price {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
      }

      /* Custom modal styles */
      .modal-product-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
      }

      .quantity-input {
        width: 80px;
      }

      .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .quantity-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #ddd;
        background: #f8f9fa;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .quantity-btn:hover {
        background: #e9ecef;
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

<div class="container d-flex flex-wrap gap-3 justify-content-center mt-5">
<?php
if ($qry->num_rows > 0) {
    $index = 0;
    while ($produk = $qry->fetch_assoc()) {
        $index++;
?>
    <div class="flip-card-container" id="card-<?= $index; ?>">
        <div class="flip-card" id="flip-<?= $index; ?>">
            <!-- FRONT -->
            <div class="flip-card-front card position-relative overflow-hidden">
                <div class="card-img position-relative">
                    <img src="asset/menu/<?= $produk['foto_produk']; ?>" class="card-img-top" alt="<?= htmlspecialchars($produk['nama_produk']); ?>">
                    <div class="img-overlay d-flex justify-content-center align-items-center">
                        <button class="btn btn-outline-info show-desc-btn">Lihat Detail</button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($produk['nama_produk']); ?></h5>
                    <p class="card-price fw-bold text-danger">Rp<?= number_format($produk['harga_produk'], 0, ',', '.'); ?></p>

                    <div style="display:flex; justify-content:center;">
                        <!-- Tombol Keranjang dengan Modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cartModal" 
                                onclick="openCartModal(<?= $produk['id_produk']; ?>, '<?= htmlspecialchars($produk['nama_produk']); ?>', <?= $produk['harga_produk']; ?>, '<?= $produk['foto_produk']; ?>')">
                            <span class="material-symbols-outlined" style="height:22px; font-size:20px;">shopping_cart</span>
                        </button>

                        <!-- Tombol Beli Sekarang dengan Modal -->
                        <button type="button" class="btn btn-danger" style="margin-left:8px;" data-bs-toggle="modal" data-bs-target="#buyModal"
                                onclick="openBuyModal(<?= $produk['id_produk']; ?>, '<?= htmlspecialchars($produk['nama_produk']); ?>', <?= $produk['harga_produk']; ?>, '<?= $produk['foto_produk']; ?>')">
                            <span>Beli Sekarang</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- BACK -->
            <div class="flip-card-back card text-white ">
                  <div class="card-body d-flex flex-column align-items-center h-100">
                    <button style="right:100%;background:transparent; color:red; border:none; right:100%; font-size:20px;"><i class="bi bi-x-circle back-btn"></i></button>
                  <p class="card-text px-3" style="color:black; margin-top:8px;"><?= $produk['deskripsi'];?></p>
                  </div>
            </div>
        </div>
    </div>

<?php
    }
} else {
    echo "Tidak ada data";
}
?>
</div>

<!-- Modal untuk Keranjang -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartModalLabel">Tambah ke Keranjang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img id="cartModalImg" src="" alt="" class="modal-product-img">
          </div>
          <div class="col-md-8">
            <h6 id="cartModalName"></h6>
            <p class="text-danger fw-bold" id="cartModalPrice"></p>
            
            <div class="quantity-controls mt-3">
              <label for="cartQuantity" class="form-label">Jumlah:</label>
              <div class="d-flex align-items-center">
                <button type="button" class="quantity-btn" onclick="changeQuantity('cart', -1)">-</button>
                <input type="number" id="cartQuantity" class="form-control quantity-input text-center mx-2" value="1" min="1">
                <button type="button" class="quantity-btn" onclick="changeQuantity('cart', 1)">+</button>
              </div>
            </div>
            
            <div class="mt-3">
              <strong>Total: Rp<span id="cartTotalPrice"></span></strong>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="cartForm" action="tambah_keranjang.php" method="POST" style="display: inline;">
          <input type="hidden" id="cartProductId" name="id_produk" value="">
          <input type="hidden" id="cartProductQuantity" name="jumlah" value="1">
          <button type="submit" class="btn btn-danger">Tambah ke Keranjang</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
document.getElementById('cartForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Biar tidak reload

    const formData = new FormData(this);

    fetch('tambah_keranjang.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        modal.hide();

        // Update angka keranjang
        updateCartCount();
    });
});
</script>


<!-- Modal untuk Beli Sekarang -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buyModalLabel">Beli Sekarang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <img id="buyModalImg" src="" alt="" class="modal-product-img">
          </div>
          <div class="col-md-8">
            <h6 id="buyModalName"></h6>
            <p class="text-danger fw-bold" id="buyModalPrice"></p>
            
            <div class="quantity-controls mt-3">
              <label for="buyQuantity" class="form-label">Jumlah:</label>
              <div class="d-flex align-items-center">
                <button type="button" class="quantity-btn" onclick="changeQuantity('buy', -1)">-</button>
                <input type="number" id="buyQuantity" class="form-control quantity-input text-center mx-2" value="1" min="1">
                <button type="button" class="quantity-btn" onclick="changeQuantity('buy', 1)">+</button>
              </div>
            </div>
            
            <div class="mt-3">
              <strong>Total: Rp<span id="buyTotalPrice"></span></strong>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="buyForm" action="payment.php" method="POST" style="display: inline;">
          <input type="hidden" id="buyProductId" name="id_produk" value="">
          <input type="hidden" id="buyProductName" name="nama_produk" value="">
          <input type="hidden" id="buyProductPrice" name="harga" value="">
          <input type="hidden" id="buyProductQuantity" name="jumlah" value="1">
          <button type="submit" name="beli" value="sekarang" class="btn btn-danger">Beli Sekarang</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let currentPrice = 0;

// Function untuk membuka modal keranjang
function openCartModal(id, name, price, foto) {
    currentPrice = price;
    
    document.getElementById('cartProductId').value = id;
    document.getElementById('cartModalName').textContent = name;
    document.getElementById('cartModalPrice').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('cartModalImg').src = 'asset/menu/' + foto;
    document.getElementById('cartModalImg').alt = name;
    document.getElementById('cartQuantity').value = 1;
    
    updateCartTotal();
}

// Function untuk membuka modal beli sekarang
function openBuyModal(id, name, price, foto) {
    currentPrice = price;
    
    document.getElementById('buyProductId').value = id;
    document.getElementById('buyProductName').value = name;
    document.getElementById('buyProductPrice').value = price;
    document.getElementById('buyModalName').textContent = name;
    document.getElementById('buyModalPrice').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(price);
    document.getElementById('buyModalImg').src = 'asset/menu/' + foto;
    document.getElementById('buyModalImg').alt = name;
    document.getElementById('buyQuantity').value = 1;
    
    updateBuyTotal();
}

// Function untuk mengubah quantity
function changeQuantity(type, change) {
    const quantityInput = document.getElementById(type + 'Quantity');
    let currentQuantity = parseInt(quantityInput.value);
    let newQuantity = currentQuantity + change;
    
    if (newQuantity < 1) newQuantity = 1;
    
    quantityInput.value = newQuantity;
    
    // Update hidden input
    document.getElementById(type + 'ProductQuantity').value = newQuantity;
    
    // Update total price
    if (type === 'cart') {
        updateCartTotal();
    } else {
        updateBuyTotal();
    }
}

// Update total price untuk keranjang
function updateCartTotal() {
    const quantity = parseInt(document.getElementById('cartQuantity').value);
    const total = currentPrice * quantity;
    document.getElementById('cartTotalPrice').textContent = new Intl.NumberFormat('id-ID').format(total);
    document.getElementById('cartProductQuantity').value = quantity;
}

// Update total price untuk beli sekarang
function updateBuyTotal() {
    const quantity = parseInt(document.getElementById('buyQuantity').value);
    const total = currentPrice * quantity;
    document.getElementById('buyTotalPrice').textContent = new Intl.NumberFormat('id-ID').format(total);
    document.getElementById('buyProductQuantity').value = quantity;
}

// Event listener untuk input quantity langsung
document.getElementById('cartQuantity').addEventListener('input', function() {
    if (this.value < 1) this.value = 1;
    updateCartTotal();
});

document.getElementById('buyQuantity').addEventListener('input', function() {
    if (this.value < 1) this.value = 1;
    updateBuyTotal();
});
</script>

<!-- flip-card script -->
<script>
document.querySelectorAll(".flip-card").forEach(card => {
    const showBtn = card.querySelector(".show-desc-btn");
    const backBtn = card.querySelector(".back-btn");
    showBtn.addEventListener("click", () => card.classList.add("flipped"));
    backBtn.addEventListener("click", () => card.classList.remove("flipped"));
});
</script>

<script>
// Fungsi untuk ambil jumlah item keranjang dari PHP
function updateCartCount() {
    fetch('get_cart_count.php')
        .then(res => res.text())
        .then(count => {
            document.getElementById('cart-count').textContent = count;
        });
}

// Panggil saat pertama kali halaman dimuat
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>


<!-- vendor scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<!-- sidebar overlay script -->
<section class="overlay"></section>
<script>
const navBar = document.querySelector("nav"),
      menuBtns = document.querySelectorAll(".menu-icon"),
      overlay  = document.querySelector(".overlay");
menuBtns.forEach(btn => btn.addEventListener("click", () => navBar.classList.toggle("open")));
overlay.addEventListener("click", () => navBar.classList.remove("open"));
</script>
</body>
</html>