<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }

    require '../connection/connection.php';
    $transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_akun = {$_SESSION['id_akun']} ORDER BY id_transaksi ASC");
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

    <h1 class="ms-5" style="margin-top:100px ;" >Daftar Transaksi</h1>
        <br>

        <table class="ms-5 " border="1" cellpadding="15" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Kuantitas</th>
                <th>Nominal</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach( $transaksi as $trans ) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $trans["nama_produk"]; ?></td>
                    <td><?= $trans["kuantitas"]; ?></td>
                    <td><?= $trans["nominal"]; ?></td>
                </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table> <br>

        <button class="ms-5" type="submit" onclick="location.href='homepage-pembeli.php';" style="border-radius: 5px; color: white; background-color: blue;">
                Kembali
        </button>

    <!-- Footer -->
    <footer class="footer text-white mt-1">
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