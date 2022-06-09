<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }

    require '../connection/connection.php';
    $_SESSION['nominal_lama'] = 0;
    $_SESSION['nominal_baru'] = 0;

    $brgs=mysqli_query($conn,"SELECT * from produk order by id_produk ASC");
    

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

    <!-- Carousel -->
    <style>
    .carousel {
        padding-top: 3px;
    }
    </style>
    <div id="carouselExampleIndicators" class="carousel slide d-flex flex-column align-items-center"
        data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/slide/1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="../assets/slide/2.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="../assets/slide/3.png" class="d-block w-100" alt="...">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Akhir Carousel -->

    <!-- Produk Rekomendasi -->
    <div class="produk">
        <h1>Produk Rekomendasi</h1>
        <div class="row mx-0 p-0 mt-3">
            <?php 
				$no=1;
				while($p=mysqli_fetch_array($brgs)){
            ?>
            <div class="col-md-4 ps-0 text-center">
                <div class="card align-items-center shadow">
                    <a href="product.php?id_produk=<?php echo $p['id_produk'] ?>">
                        <img src="<?php echo $p['gambar']?>" width="200px" height="250px" class="card-img-top"
                            alt="laptop">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo $p['namaproduk'] ?></h5>
                            <hr style="color: #446CB3;">
                            <h5 class="fw-bold">Rp. <?php echo number_format($p['hargaproduk'])?></h5>
                            <a href="product.php?id_produk=<?php echo $p['id_produk'] ?>"
                                class="btn btn-beli mt-2 text-white">Beli</a>
                        </div>
                    </a>
                </div>
            </div>
            <?php
				}
			?>
        </div>
    </div>
    <!-- Akhir Produk Rekomendasi -->

    <!-- Footer -->
    <footer class="footer text-white">
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