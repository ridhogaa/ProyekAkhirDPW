<?php
    session_start();
    if (isset($_SESSION["login"])) {
        header("Location: view/homepage-pembeli.php");
        exit;
    }

    $_SESSION['nominal_lama'] = 0;
    $_SESSION['nominal_baru'] = 0;
    $_SESSION['updated'] = 'no';
    
    require 'connection/connection.php';
    
    if( isset($_POST["login"]) ) {
        
        $email = $_POST["nomorhp-email"];
        $nomorhpemail = $_POST["nomorhp-email"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM akun where email = '$email' or no_telp = '$nomorhpemail'");
        if(mysqli_num_rows($result) === 1) {
            
            $row = mysqli_fetch_assoc($result);
            $result2 = mysqli_query($conn, "SELECT * FROM reseller where id_akun = '{$row['id_akun']}'");
            $row2 = mysqli_fetch_assoc($result2);

            if(strcmp($password, $row["password"]) === 0){
                $getid = $row['id_akun'];
                $_SESSION["login"] = true;
                $_SESSION["id_akun"] = $row['id_akun'];
                $_SESSION["email"] = cutName($row['email']);
                $_SESSION["password"] = $row['password'];
                $_SESSION['namatoko'] = $row2['nama_toko'];
                echo "<script> alert ('Berhasil Login');
                    window.location.href='view/homepage-pembeli.php'
                </script>";
            } else {
            echo "<script> alert ('Gagal Login');
                window.location.href='index.php'
                </script>";
            }
        } 
    }

    function cutName($data){
        $nama = $data;
        $hasil = explode("@", $nama);
        $hasil = strtolower(reset($hasil));
        return $hasil;
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-homepage navbar-expand-lg navbar-dark fixed-top shadow"
        style="background-color: #446CB3;">
        <div class="container-fluid">
            <div id="navbar-bg-gelap" onclick="masukOn()"></div>
            <div id="navbar-bg-gelap2" onclick="daftarOn()"></div>
            <a class="navbar-brand" href="" onclick="reloadOn()">JASR Tech</a>
            <img class="icon-category mx-3" src="assets/img/category.png" alt="">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Cari barang" aria-label="Search" size="98"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                <button class="btn btn-outline-light ms-3 me-4" type="button">Search</button>
            </form>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item text-white">
                        <button class="text-white" type="button" onclick="masukOn()">Masuk</button>
                    </li>
                    <li class="nav-item text-white">
                        <i class="line mx-3">|</i>
                    </li>
                    <li class="nav-item text-white">
                        <a href="view/daftar.php"><button class="text-white" type="button">Daftar</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->

    <!-- Masuk -->
    <div class="masuk fixed-top" id="masuk">
        <i class="close bi bi-x-lg text-secondary d-flex justify-content-end" onclick="masukOn()"></i>
        <a href="index.php">
            <img class="icon-jasrtech d-flex" src="assets/img/jasrtech.png" alt="">
        </a>
        <div class="d-flex justify-content-between my-4">
            <span class="masuk-2 fw-bold">Masuk</span>
            <a href="view/daftar.php">Daftar</a>
        </div>

        <form action="" method="POST">
            <label class="nomorhp-email" for="nomorhp-email">Nomor HP atau Email</label><br>
            <input class="form-control my-1" type="text" id="nomorhp-email" name="nomorhp-email" autocomplete="off">
            <label class="password" for="password">Password</label><br>
            <input class="form-control my-1" type="password" id="password" name="password" autocomplete="off">
            <a class="d-flex justify-content-end" href="view/lupakatasandi.php">Lupa kata sandi?</a>
            <a href="view/homepage-pembeli.php">
                <button class="btn-login mt-2 text-white" type="submit" name="login">Login</button>
            </a>
        </form>
    </div>
    <!-- Akhir Masuk -->

    <!-- Carousel -->
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
                <img src="assets/slide/1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="assets/slide/2.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="assets/slide/3.png" class="d-block w-100" alt="...">
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

    <hr class="horizontal position-relative" style="top:126px; margin-left: 68px; width:90%; color: #446CB3;">

    <!-- Produk Rekomendasi -->
    <div class="produk">
        <h1>Produk Rekomendasi</h1>
        <div class="row mx-0 p-0 mt-3">
            <?php 
				$brgs=mysqli_query($conn,"SELECT * from produk order by id_produk ASC");
				$no=1;
				while($p=mysqli_fetch_array($brgs)){
            ?>
            <div class="col-md-4 ps-0 text-center">
                <div class="card align-items-center shadow">
                    <a href="view/masuk.php">
                        <img src="view/<?php echo $p['gambar']?>" width="200px" height="250px" class="card-img-top"
                            alt="laptop">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo $p['namaproduk'] ?></h5>
                            <hr style="color: #446CB3;">
                            <h5 class="fw-bold">Rp. <?php echo number_format($p['hargaproduk'])?></h5>
                            <a href="view/beli-produk-homepage-laptop.php" class="btn btn-beli mt-2 text-white">Beli</a>
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
                <a class="me-3" href="view/tentang-kami.php" target="_blank">Tentang Kami</a>
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

    <script src="js/script.js"></script>
</body>

</html>
