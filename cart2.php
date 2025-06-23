<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT keranjang.id_keranjang, produk.foto_produk, produk.nama_produk, produk.harga_produk, keranjang.jumlah, keranjang.total 
        FROM keranjang  
        JOIN produk ON keranjang.id_produk = produk.id_produk 
        WHERE keranjang.id_user = '$id_user'";

$query = mysqli_query($koneksi, $sql);

// total harga awal
$total_harga = 0;
$items = [];

while($cart = mysqli_fetch_assoc($query)) {
    $items[] = $cart;
    $total_harga += $cart['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font GOOGLE -->
    <link href='https://fonts.googleapis.com/css2?family=Jockey+One&family=Jomolhari&family=Trispace:wght@100..800&family=Unbounded:wght@200..900&display=swap' rel='stylesheet' >

    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- font-awsome icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icon From Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete" />

     <!-- icon atas (Boxicons)-->
     <link rel="shortcut icon" type="image/png/jpg" href="asset/icon meijin.png">
    <title>Meijin Meals</title>

    <link rel="stylesheet" href="cart.css">

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

    <!-- Cart -->
    <div class="container-fluid" style="margin-top:50px;">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <div class="row mt-5 gx-3">
                    <!-- left side div -->
                     <h2 class="py-4 font-weight-bold" style="font-size:38px;">Your Cart</h2>
                    <div class="col-md-12 col-lg-8 col-11 mx-auto main_cart mb-lg-0 mb-5 shadow">
                        <?php foreach ($items as $index => $item): ?>
                        <div class="card p-4"  data-index="<?= $index ?>">
                            
                            <div class="row">
                                <!-- cart images div -->
                                <div class="col-md-5 col-11 mx-auto bg-light d-flex justify-content-center align-items-center shadow product_img">
                                    <img src="asset/menu/<?= $item['foto_produk'] ?>" class="img-fluid" alt="cart img">
                                </div>
                                <!-- cart product details -->
                                <div class="col-md-7 col-11 mx-auto px-4 mt-2">
                                    <div class="row">
                                        <!-- product name  -->
                                        <div class="col-6 card-title">
                                            <h1 class="mb-4 product_name"><?= $item['nama_produk'] ?></h1>
                                            <p>Rp <span><?= $item['harga_produk'] ?></span></p>
                                        </div>

                                        <!-- quantity inc dec -->
                                        <div class="col-6">

                                        <div class="quantity" style="display:flex;">
                                            <button onclick="ubahJumlah(<?= $index ?>, -1, <?= $item['id_keranjang'] ?>, <?= $item['harga_produk'] ?>)" style="width:26px;">-</button>
                                            <input type="text" value="<?= $item['jumlah'] ?>" id="qty<?= $index ?>" readonly style="width:35px;">
                                            <button onclick="ubahJumlah(<?= $index ?>, 1, <?= $item['id_keranjang'] ?>, <?= $item['harga_produk'] ?>)" style="width:26px;">+</button>
                                        </div>

                                            <!-- <ul class="pagination justify-content-end set_quantity" style="margin-top:20px;">
                                                <li class="page-item">
                                                    <button class="page-link " onclick="decreaseNumber('textbox','itemval')">
                                                    <i class="fas fa-minus"></i> </button>
                                                </li>
                                                <li class="page-item">
                                                    <input type="text" class="page-link" value="0" id="textbox" >
                                                </li>
                                                <li class="page-item">
                                                    <button class="page-link" onclick="increaseNumber('textbox','itemval')"> <i class="fas fa-plus"></i></button>
                                                </li>
                                            </ul> -->
                                        </div>
                                    </div>


                                    <!-- //remover move and price -->
                                    <div class="row">
                                        <div class="col-8 d-flex justify-content-between remove_wish">
                                            <a href="hapus-keranjang.php?id_produk=<?= $item['id_keranjang'] ?>"><p><i class="fas fa-trash-alt"></i></p></a>
                                        </div>
                                        <div class="col-4 d-flex justify-content-end price_money">
                                            <h3>Rp<span id="subtotal<?= $index ?>"><?= number_format($item['total']) ?></span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <hr>                        
                    </div>

                    <!-- right side div -->
                    <div class="col-md-12 col-lg-4 col-11 mx-auto mt-lg-0 mt-md-5">
                        <div class="right_side p-3 shadow bg-white">
                            <h2 class="product_name mb-5">Rincian Pembelian:</h2>
                            
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Jumlah Harga</p>
                                <p>Rp<span id="product_total_amt"></span></p>
                            </div>
                            <!-- <div class="total_indiv d-flex justify-content-between">
                                <p>Potongan Diskon</p>
                                <p>Rp <span id="product_discount">0</span></p>
                            </div> -->
                            <!-- <div class="price_indiv d-flex justify-content-between">
                                <p>Shipping Charge</p>
                                <p>$<span id="shipping_charge">50.0</span></p>
                            </div> -->
                            <hr>
                            <div class="total-amt d-flex justify-content-between font-weight-bold">
                                <p>Total</p>
                                <p>Rp<span id="total_cart_amt"><?= number_format($total_harga) ?></span></p>
                            </div>
                           <form action="payment.php" method="POST">
                                <?php foreach ($items as $index => $item): ?>
                                    <input type="hidden" name="produk[<?= $index ?>][id_keranjang]" value="<?= $item['id_keranjang'] ?>">
                                    <input type="hidden" name="produk[<?= $index ?>][nama]" value="<?= $item['nama_produk'] ?>">
                                    <input type="hidden" name="produk[<?= $index ?>][harga]" value="<?= $item['harga_produk'] ?>">
                                    <input type="hidden" name="produk[<?= $index ?>][jumlah]" id="form_jumlah<?= $index ?>" value="<?= $item['jumlah'] ?>">
                                <?php endforeach; ?>

                                <input type="hidden" name="total" id="form_total" value="<?= $total_harga ?>">
                                <input type="hidden" name="diskon" id="form_diskon" value="0">

                                <button type="submit" class="btn btn-danger text-uppercase">Checkout</button>
                            </form>


                        </div>

                        <!-- discount code part -->
                        <!-- <div class="discount_code mt-3 shadow">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex justify-content-between" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <p style="text-decoration:none; list-style:none; color:black;">Masukan kode voucher</p>
                                        <span><i class="fas fa-chevron-down pt-1"></i></span>
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="mt-3">
                                            <input type="text" id="discount_code1" placeholder="Masukkan kode diskon">
                                        </div>
                                        <button class="btn btn-danger btn-sm mt-3" onclick="discount_code()">Submit</button>
                                        <p id="error_trw" style="color:red;"></p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
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

document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
<!-- Optional JavaScript -->
<!-- Popper.js first, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

<!-- <script src="main.js"></script> -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <section class="overlay"></section>
    <script>
let hargaProduk = <?= json_encode(array_column($items, 'harga_produk')) ?>;
let jumlahProduk = <?= json_encode(array_column($items, 'jumlah')) ?>;

// let diskonSudahDipakai = false;
// let potonganDiskon = 0;

// mengubah jumlah harga berdasarkan input angka
function ubahJumlah(index, perubahan, idKeranjang, harga) {
    let qtyInput = document.getElementById('qty' + index);
    let qty = parseInt(qtyInput.value) + perubahan;
    if (qty < 1) return;
    qtyInput.value = qty;

    let subtotal = harga * qty;
    document.getElementById('subtotal' + index).innerText = subtotal.toLocaleString('id-ID');
    jumlahProduk[index] = qty;
    document.getElementById('form_jumlah' + index).value = qty;

    // AJAX untuk update database
    $.ajax({
        url: 'update-keranjang.php',
        method: 'POST',
        data: {
            id_keranjang: idKeranjang,
            jumlah: qty,
            harga: harga
        },
        success: function(res) {
            console.log("Updated: ", res);
        },
        error: function() {
            alert('Gagal update jumlah di server');
        }
    });

    hitungTotal();
}

// untuk menghitung total
function hitungTotal() {
    let total = 0;
    for (let i = 0; i < hargaProduk.length; i++) {
        total += hargaProduk[i] * jumlahProduk[i];
    }

    // menampilkan hasil total dan jumlah pembelian
    document.getElementById('product_total_amt').innerText = total.toLocaleString('id-ID');
    document.getElementById('total_cart_amt').innerText = total.toLocaleString('id-ID');


    // let totalSetelahDiskon = total - potonganDiskon;
    // document.getElementById('total_cart_amt').innerText = totalSetelahDiskon.toLocaleString('id-ID');

    // Update input hidden total
    document.getElementById('form_total').value = total;
}

// function discount_code() {
//     let kode = document.getElementById('discount_code1').value.trim();

//     let total = 0;
//     for (let i = 0; i < hargaProduk.length; i++) {
//         total += hargaProduk[i] * jumlahProduk[i];
//     }

//     if (diskonSudahDipakai) {
//         document.getElementById('error_trw').innerText = "Diskon sudah digunakan.";
//         return;
//     }

//     if (kode === 'agesa') {
//         potonganDiskon = 5000;
//         diskonSudahDipakai = true;
//         document.getElementById('product_discount').innerText = potonganDiskon.toLocaleString('id-ID');
//         document.getElementById('error_trw').innerText = "Selamat, Anda dapat diskon Rp5.000!";
//     } else {
//         potonganDiskon = 0;
//         document.getElementById('product_discount').innerText = "0";
//         document.getElementById('error_trw').innerText = "Kode diskon salah!";
//     }

    // Update tampilan total setelah diskon
    // let totalSetelahDiskon = total - potonganDiskon;
    // document.getElementById('total_cart_amt').innerText = totalSetelahDiskon.toLocaleString('id-ID');

    // Update input hidden untuk form
    document.getElementById('form_total').value = total;
//     document.getElementById('form_diskon').value = potonganDiskon;
// }
</script>


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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
</body>
</html>
