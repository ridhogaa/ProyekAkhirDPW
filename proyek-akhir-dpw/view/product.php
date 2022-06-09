<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: homepage-pembeli.php");
        exit;
    }
    require '../connection/connection.php';
    $id_produk = $_GET['id_produk'];
    if(isset($_POST['keranjang'])){
        $cek = mysqli_query($conn,"select * from cart where id_produk='$id_produk' and id_akun = '{$_SESSION["id_akun"]}'");
        $liat = mysqli_num_rows($cek);
        if($liat > 0){
            echo "<script> alert ('Anda sudah pernah menambahkan ke keranjang!! Silakan cek keranjang');
                </script>";
        } else {
            $bikincart = mysqli_query($conn,"insert into cart (id_produk, id_akun) values('$id_produk','{$_SESSION["id_akun"]}')");
            echo "<script> alert ('Berhasil menambahkan ke keranjang!!');
                    window.location.href='cart.php'
                </script>";
        }
    }

    if(isset($_POST['langsung'])){

    }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyek Akhir Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">

    <!-- My CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="bg-gelap" onclick="keluarOn()"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-homepage navbar-homepage-pembeli-penjual navbar-expand-lg navbar-dark fixed-top shadow"
        style="background-color: #446CB3;">
        <div class="container-fluid">
            <div id="navbar-bg-gelap" onclick="masukOn()"></div>
            <div id="navbar-bg-gelap2" onclick="daftarOn()"></div>
            <a class="navbar-brand" href="homepage-pembeli.php" onclick="reloadOn()">JASR Tech</a>
            <img class="icon-category mx-3" src="../assets/img/category.png" alt="">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Cari barang" aria-label="Search" size="80"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" name="keyword">
                <button class="btn btn-outline-light ms-3 me-4" type="button" name="cari">Search</button>
            </form>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a href="cart.php">
                            <img class="icon-cart nav-link active" src="../assets/img/cart.png" alt=""
                                aria-current="page">
                        </a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="<?php
                            $result = mysqli_query($conn, "SELECT * FROM reseller where id_akun = '{$_SESSION["id_akun"]}'");
                            if(mysqli_num_rows($result) === 1) {
                                echo "product-seller.php";
                            }else {
                                echo "seller.php";
                            }
                        ?>">
                            <img class="icon-seller nav-link" src="../assets/img/seller.png" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="#"
                            onclick="keluarOn()">
                            <img class="icon-seller nav-link" src="../assets/img/user.png" alt="" style="float:left;">
                            <span><?php echo $_SESSION["email"]; ?></span>
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="text-decoration-none" href="list-transaksi.php" style="color: #31353BAD;">
                            <h6 class="mt-3 text-center">List Transaksi</h6>
                        </a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="text-decoration-none" href="logout.php" style="color: #31353BAD;">
                            <h6 class="mt-3 text-center">Keluar<i class="bi bi-box-arrow-left ms-2"></i></h6>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <!-- Pembeli -->
    <!-- <div class="pembeli-penjual d-flex align-items-center d-flex-column" id="pembeli-penjual">
        <div class="pembeli-penjual-2 d-flex">
            <img class="icon-seller nav-link me-2" src="../assets/img/user.png" alt="" style="float:left;">
            <span class="m-auto fw-bold"></span><br>
        </div>

        <div class="keluar">
            <a class="text-decoration-none" href="profil-pembeli.php">
                <span class="text-center">Update Profile</span>
            </a>
            <a class="text-decoration-none" href="logout.php" style="color: #31353BAD;">
                <h6 class="mt-3 text-center">Keluar<i class="bi bi-box-arrow-left ms-2"></i></h6>
            </a>
        </div>
    </div> -->
    <!-- Akhir Pembeli -->

    <!-- Produk -->
    <style>
    .beli-produk-homepage {
        padding-top: 85px;
    }

    .beli-produk-homepage a {
        text-decoration: none;
        color: black;
    }

    .asus {
        cursor: default;
    }
    </style>
    <div class="beli-produk-homepage">
        <form action="" method="POST">
            <a href="homepage-pembeli.php">
                <span class="ms-3">Home</span>
            </a>
            <i class="bi bi-caret-right-fill"></i>
            <span class="asus ">
                <?php 
                $p = mysqli_fetch_array(mysqli_query($conn,"Select * from produk where id_produk='$id_produk'"));
				echo $p['namaproduk'];
            ?>
            </span>

            <div class="row mx-0 p-0 mt-3">
                <div class="my-1 container text-center">
                    <div class="row">
                        <div class="col container laptop">
                            <div style="border: 2px solid #446CB3; border-radius: 10px; cursor: crosshair;">
                                <style>
                                .laptop .asus {
                                    width: 70%;
                                    cursor: crosshair;
                                }

                                .laptop .asus:hover {
                                    width: 90%;
                                    cursor: crosshair;
                                }
                                </style>
                                <img width="250px" height="400px" src="<?php echo $p['gambar']?>"
                                    class="card-img-top asus" alt="laptop">
                            </div>
                        </div>

                        <div class="col">
                            <div class="card-body ms-auto" style="text-align: left;">
                                <h1 class="text-center"><?php echo $p['namaproduk']?></h1>
                                <h3 class="text-center">Harga : Rp.<?php echo number_format($p['hargaproduk'])?></h3>
                                <h5>Deskripsi Produk : </h5>
                                <h5>• <?php echo $p['deskripsi']?></h5>
                                <br>
                                <h5>Spesifikasi :</h5>
                                <h5>• Kategori : <?php echo $p['katproduk']?></h5>
                                <h5>• Berat Produk : <?php echo $p['beratproduk']?> </h5>
                                <h5>• Stok Produk : <?php echo $p['stokproduk']?></h5>
                                <br><br>
                                <button type="submit" name="keranjang"
                                    style="border-radius: 5px; background-color: white; color: #446CB3; width: 150px; height: 40px;">+Keranjang</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <!-- Akhir Produk -->

    <!-- Footer -->
    <footer class="footer footer-beli-produk text-white" style="margin-top:auto ;">
        <div class="info container-fluid d-flex">
            <span class="indonesia ms-2">ID - Indonesia</span>
            <div class="tentang ms-auto">
                <a class="me-3" href="tentang-kami.php" target="_blank">Tentang Kami</a>
                <a class="me-3" href="">Panduan</a>
                <a class="me-3" href="">Syarat & Ketentuan</a>
                <a class="me-3" href="">FAQ</a>
            </div>
        </div>

        <div class="copyright container-fluid text-center pt-3 pb-3">
            <span>Copyright © 2022</span>
        </div>
    </footer>
    <!-- Akhir Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script src="../js/script.js"></script>
</body>

</html>