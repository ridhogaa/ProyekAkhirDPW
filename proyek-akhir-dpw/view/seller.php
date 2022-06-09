<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../index.php");
        exit;
    }
    require '../connection/connection.php';

    if( isset($_POST["lanjut"]) ) {
        if (registrasiReseller($_POST) > 0) {
            echo "<script> alert ('Sukses melengkapi Profil!!');
                window.location.href='seller-upload.php'
                </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
    

    function registrasiReseller($data){
        global $conn;

        $nohp = $data["masukan-nomorhp"];
        $namatoko = $data["masukan-namatoko"];
        $domain = $data["masukandomain"];
        $alamat = $data["masukan-alamat"];
        $flag1 = strcmp($nohp, '') === 0 || strcmp($namatoko, '') === 0 || strcmp($domain, '') === 0 || strcmp($alamat, '') === 0;
        if($flag1){
            echo "<script> alert ('Data Tidak Boleh Kosong!!'); 
                </script>";
            return false;
        } else {
            mysqli_query($conn, "INSERT INTO reseller VALUES('', '$nohp', '$namatoko', '$domain', 
                    '$alamat', '{$_SESSION["id_akun"]}', '0')");
            $result2 = mysqli_query($conn, "SELECT * FROM reseller where id_akun = '{$_SESSION["id_akun"]}'");
            $row2 = mysqli_fetch_assoc($result2);
            $_SESSION['namatoko'] = $row2['nama_toko'];
        }
        return mysqli_affected_rows($conn);
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
            <a class="navbar-brand" href="product-seller.php" onclick="reloadOn()">JASR Tech Seller</a>
            <img class="icon-category mx-3" src="../assets/img/category.png" alt="">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Cari barang" aria-label="Search" size="80"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                <button class="btn btn-outline-light ms-3 me-4" type="button">Search</button>
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
                        <a href="seller.php">
                            <img class="icon-seller nav-link" src="../assets/img/seller.png" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="#"
                            onclick="keluarOn()">
                            <img class="icon-seller nav-link" src="../assets/img/shop.png" alt="" style="float:left;">
                            <span><?php echo $_SESSION["email"]; ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="seller-upload.php">
                            <h5 class="text-center">Upload Produk</h5>
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="product-seller.php">
                            <h5 class="text-center">Produk Kamu</h5>
                        </a>
                    </li>
                    <li>
                        <a class="text-decoration-none" href="homepage-pembeli.php">
                            <h5 class="text-center">Kembali ke Pembeli</h5>
                        </a>
                    </li>
                    <li>
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
            <a class="text-decoration-none" href="profil-penjual.php">
                <span class="text-center">Update Profile</span>
            </a>
            <a class="text-decoration-none" href="seller-upload.php">
                <h5 class="text-center">Upload Produk</h5>
            </a>
            <a class="text-decoration-none" href="product-seller.php">
                <h5 class="text-center">Produk Kamu</h5>
            </a>
            <a class="text-decoration-none" href="logout.php" style="color: #31353BAD;">
                <h6 class="mt-3 text-center">Keluar<i class="bi bi-box-arrow-left ms-2"></i></h6>
            </a>
        </div>
    </div> -->
    <!-- Akhir Pembeli -->

    <!-- Seller -->
    <div class="seller">
        <div class="container">
            <form action="" method="post">
                <h3 class="ms-0 pt-4">Halo, <b><?php echo $_SESSION["email"]; ?></b>&nbsp;ayo isi detail tokomu!</h3>
                <label class="masukan-nomorhp fw-bold mt-4" for="masukan-nomorhp">Masukkan Nomor Handphone!</label><br>
                <input class="form-control my-2" type="text" id="masukan-nomorhp" name="masukan-nomorhp"><br>
                <label class="masukan-namatoko fw-bold mt-4" for="masukan-namatoko">Masukkan Nama Toko dan
                    Domain!</label><br>
                <span>Nama Toko</span><br>
                <input class="form-control my-2 me-2" type="text" id="masukan-namatoko" name="masukan-namatoko">
                <span><i>maksimal 30 karakter</i></span><br><br>
                <span>Nama Domain</span><br>
                <span class="fw-bold">jasrtech.com/
                    <input class="form-control my-1 mx-2" type="text" id="masukan-namatoko" placeholder="jasrtech.com"
                        name="masukandomain">
                    <span><i>maksimal 30 karakter</i></span></span><br>
                <label class="masukan-alamat fw-bold mt-4" for="masukan-alamat">Masukkan Alamat Tokomu!</label><br>
                <input class="form-control my-2" type="text" id="masukan-alamat" name="masukan-alamat"><br>
                <button class="btn btn-lanjut text-white mt-2" type="submit" name="lanjut">Lanjut</button>
                <div class="pb-4"></div>
            </form>
        </div>
    </div>
    <!-- Akhir Seller -->

    <!-- Footer -->
    <footer class="footer footer-seller text-white">
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