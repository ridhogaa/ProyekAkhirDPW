<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../index.php");
        exit;
    }
    
    require '../connection/connection.php';
    $_SESSION['nominal_lama'] = 0;
    $_SESSION['nominal_baru'] = 0;
    if (isset($_POST['hapusproduk'])) {
        $kode = $_POST['idproduknya'];
        $q2 = mysqli_query($conn,"delete from produk where id_produk = '$kode'");
        if($q2){
            echo "<script> alert ('Produk Berhasil dihapus!!');
                </script>";
        } else {
            echo "Gagal Hapus!";
        }
    }

    if(isset($_POST['simpanbtn'])){
        $kode = $_POST['idproduknya'];
        $stoknow = $_POST['stoknow'];
        $isistok = $_POST['isistok'];
        $jumlah = $stoknow + $isistok;
        $q2 = mysqli_query($conn,"update produk set stokproduk = '$jumlah' where id_produk = '$kode'");
        if($q2){
            echo "<script> alert ('Produk Berhasil diupdate!!');
                </script>";
        } else {
            echo "Gagal Update!";
        }
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
            <div id="navbar-bg-gelap4" onclick="passwordpenjualOn()"></div>
            <a class="navbar-brand" href="" onclick="reloadOn()">JASR Tech Seller</a>
            <img class="icon-category mx-3" src="../assets/img/category.png" alt="">
            <form class="d-flex" role="search">
                <input class="form-control" type="search" placeholder="Cari barang" aria-label="Search" size="82"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                <button class="btn btn-outline-light ms-3 me-5" type="button">Search</button>
            </form>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-white text-decoration-none" href="#"
                            onclick="keluarOn()">
                            <img class="icon-seller nav-link" src="../assets/img/shop.png" alt="" style="float:left;">
                            <span><?php echo $_SESSION['namatoko']; ?></span>
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

    <!-- Penjual -->
    <!-- <div class="pembeli-penjual d-flex align-items-center d-flex-column" id="pembeli-penjual">
        <div class="pembeli-penjual-2 d-flex">
            <img class="icon-seller nav-link me-2" src="../assets/img/shop.png" alt="" style="float:left;">
            <span class="m-auto fw-bold"></span>
        </div>

        <div class="keluar">
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
    <!-- Akhir Penjual -->

    <!-- Produk Seller -->
    <div class="produk" style="top: 80px;">
        <h1 class="text-center">Produk yang kamu jual</h1>
        <?php 
			$brgs=mysqli_query($conn,"SELECT * from produk where id_akun = {$_SESSION['id_akun']} order by id_produk ASC");
			$no=1;
				while($p=mysqli_fetch_array($brgs)){
        ?>
        <form action="" method="post">
            <div class="row mx-0 p-0 mt-3">
                <div class="my-2 container text-center" style="border: 2px solid #446CB3; border-radius: 10px;">
                    <div class="row">
                        <div class="col">
                            <img src="<?php echo $p['gambar']?>" class=" card-img-top" alt="">
                            <hr style="color: #446CB3 ;">
                            <div class="card-body">
                                <h5><?php echo $p['namaproduk'] ?></h5>
                                <h5 class="fw-bold">Rp. <?php echo number_format($p['hargaproduk'])?></h5>
                            </div>
                        </div>
                        <div class="col" style="margin-top: auto; margin-bottom: auto;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold my-2 text-center">Item Summary</h5>
                                <h5 class="text-center mt-3">• <?php echo $p['deskripsi']?></h5>
                                <h5>• Kategori : <?php echo $p['katproduk']?></h5>
                                <h5>• Berat Produk : <?php echo $p['beratproduk']?> </h5>
                                <h5>• Stok Produk : <?php echo $p['stokproduk']?></h5>
                                <div class="jumlah mt-2 text-center">
                                    <style>
                                    .produk button {
                                        border: none;
                                        background: none;
                                    }
                                    </style>
                                    <input type="hidden" name="idproduknya" value="<?php echo $p['id_produk'] ?>" \>
                                    <input type="hidden" name="stoknow" value="<?php echo $p['stokproduk'] ?>" \>
                                    <div>
                                        <input
                                            style="text-align:center; width:100px; height: 35px; border-radius: 10px;"
                                            type="number" name="isistok" value="0">
                                    </div>
                                    <button class="m-auto" name="hapusproduk" type="submit"> <img
                                            src="../assets/img/trash.png" alt=""></button>
                                    <button name="simpanbtn" type="submit"> <img alt="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php }?>
    </div>
    <!-- Akhir Produk Seller -->

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