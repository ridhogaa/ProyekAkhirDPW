<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../index.php");
        exit;
    }
    require '../connection/connection.php';

    function fetch_assoc($query){
        global $conn;

        $result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($result);
    }

    $s = $_SESSION["nominal_lama"];

    $uid = (int) $_SESSION["id_akun"];
    $caricart = mysqli_query($conn,"select * from cart where id_akun='$uid'");
	$fetc = mysqli_fetch_array($caricart);

    if(isset($_POST["update"])){
        $id_c = (int) $_POST['idcart']; //id_keranjang dari tabel cart
        $data_k = fetch_assoc("SELECT * FROM cart WHERE id_keranjang = $id_c");
        $kode = (int) $_POST['idproduknya']; //id_produk dari tabel cart
        $jumlah = (int) $_POST['jumlah']; //input kuantitas dari label/input

        if( $jumlah < 1 ) {
            echo "
                    <script>
                        alert('Kuantitas Barang setidaknya 1');
                        document.location.href = 'cart.php';
                    </script>
                    ";
            return 0;
        }
        $data_order = fetch_assoc("SELECT * FROM detailorder WHERE id_produk = $kode"); // Ambil data order
        $kuanti = (int) $data_order['qty'];
        $total_order = $jumlah + $kuanti;

        $data_produk = fetch_assoc("SELECT * FROM produk WHERE id_produk = $kode"); // Ambil data produknya
        $stock_produk = (int) $data_produk['stokproduk'];
        $harga_produk = (int) $data_produk['hargaproduk'];

        if($total_order <= $stock_produk) {
            if(strcmp($_SESSION['updated'], 'no') == 0){
                $query = "SELECT * FROM detailorder WHERE id_produk = $kode";
                $cari_order = fetch_assoc($query);
                $cek_id = $cari_order['id_produk'];

                if( $kode == $cek_id ) {
                    $_SESSION['updated'] = 'yes';
                    echo "
                    <script>
                        alert('Anda Hanya Bisa Mengupdate/Menghapus Pesanan Inis');
                        document.location.href = 'cart.php';
                    </script>
                    ";
                return 0;
                }

                $nom = $jumlah * $harga_produk;
                $query = "INSERT INTO detailorder VALUES('', $kode, $jumlah, $nom, $uid)";
                $_SESSION['nominal_baru'] = $s + $nom;
                mysqli_query($conn, $query);
                $_SESSION['updated'] = 'yes';
                echo "
                <script>
                alert('Pesanan Ditambahkan');
                document.location.href = 'cart.php';
                </script>
                ";
                
            }else {
                $nom = $jumlah * $harga_produk;
                $data_order = fetch_assoc("SELECT * FROM detailorder WHERE id_produk = $kode");
                $cek_id = $data_order['id_produk'];
                
                if( $kode != $cek_id ) {
                    $_SESSION['updated'] = 'no';
                    echo "
                    <script>
                    alert('Anda belum menentukan kuantitas barang ini');
                    document.location.href = 'cart.php';
                    </script>
                    ";
                    return 0;
                }
                $e = (int) $data_order['harga'];
                $d = $e + $nom;
                $id_o = $data_order['id_order'];
                $query = "UPDATE detailorder SET qty = $total_order, harga=$d
                WHERE id_order = $id_o";
                mysqli_query($conn, $query);

                $data_order = fetch_assoc("SELECT * FROM detailorder WHERE id_produk = $kode");
                $_SESSION['nominal_baru'] += $nom;

                echo "<script> 
                    alert ('Order berhasil diupdate');
                    document.location.href = 'cart.php';
                    </script>";
            }
        }else {
            echo "<script>
                alert('Kuantitas tidak dapat melebihi stock yang ada');
                document.location.href = 'cart.php';
            </script>
            ";
        }
    } else if(isset($_POST["hapus"])){
        $kode = $_POST['idproduknya'];
        var_dump($kode);
        $q2 = mysqli_query($conn, "DELETE FROM cart WHERE id_produk='$kode'");
        if($q2){
            echo "Berhasil Hapus";
        } else {
            echo "Gagal Hapus";
        }
    }

    $_SESSION["nominal_lama"] = $_SESSION["nominal_baru"];

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

    <!-- Cart -->
    <div class="cart" style="margin-left: auto;">
        <div>
            <h3>Keranjang</h3>
            <hr class="horizontal position-relative" style="top:8px; margin-left: 68px; width:90%; color: #446CB3;">
        </div>
        <div class="pilih">

            <?php 
			$brgs=mysqli_query($conn,"SELECT * from cart c, produk p where c.id_akun = {$_SESSION['id_akun']} and c.id_produk=p.id_produk group by p.id_produk order by c.id_keranjang ASC");
            $st = "SELECT * from reseller r, produk p where r.id_akun = {$_SESSION['id_akun']} and r.id_akun = p.id_akun group by r.id_akun";
            $brgs2=mysqli_query($conn, $st);
            $row2 = mysqli_fetch_assoc($brgs2);
            $jumlah=0;
				while($p=mysqli_fetch_array($brgs)){
                    $id_p = $p['id_produk'];
                    $brgs3 = mysqli_query($conn, "SELECT * FROM produk p where id_produk = $id_p");
                    $row3 = mysqli_fetch_assoc($brgs3);
                    $id_a = $row3['id_akun'];
                    $reseller = mysqli_query($conn, "SELECT * FROM reseller r where id_akun = $id_a");
                    $row4 = mysqli_fetch_assoc($reseller);
                ?>
            <form action="" method="POST">
                <img class="mb-3" src="../assets/img/user-2.png" alt=""><label
                    for="penjual"><?php echo $row4['nama_toko'] ?></label>
                <div class="cart-2 ">
                    <div class="row mx-0 p-0">
                        <div class="col-md-6 ps-0">
                            <div class="card shadow" style="width: 18rem;">
                                <img width="60px" src="<?php echo $p['gambar'] ?>" class="card-img-top laptop"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p['namaproduk'] ; ?></h5>
                                    <hr style="color: #446CB3;">
                                    <h5 class="fw-bold">Rp. <?php echo number_format($p['hargaproduk'])?></h5>
                                </div>
                            </div>
                            <div class="jumlah mt-2">
                                <input type="hidden" name="idcart" value="<?= $p['id_keranjang'] ?>">
                                <input type="hidden" name="idproduknya" value="<?php echo $p['id_produk'] ?>">
                                <input type="hidden" name="hargaproduk" value="<?php echo $p['hargaproduk'] ?>">
                                <input class="ms-5"
                                    style="text-align:center; width:100px; height: 35px; border-radius: 10px;"
                                    type="number" name="jumlah" value="0">
                                <button type="submit" name="hapus"><img src="../assets/img/trash.png" alt=""></button>

                                <button class=""
                                    style="border-radius: 10px ; background-color: #446CB3; width: 100px  ;height: 35px; color: white;"
                                    type="submit" name="update">Update</button>
                            </div>
                        </div>
            </form>
        </div> <?php }?>

        <div class=" col ps-0">
            <div class="card" style="width: 18rem;">
                <div class="card-body text-center">
                    <h5 class="card-title totalharga">Total Harga</h5>
                    <hr style="color: #446CB3;">
                    <h5 class="fw-bold mb-3">Rp. <?php echo number_format($_SESSION["nominal_lama"]); ?>
                    </h5>
                    <button class="mt-2 btn btn-checkout text-white" type="button" name="checkout"
                        onclick="location.href='checkout.php';">Checkout
                    </button>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    </div>
    </div>
    <!-- Akhir Cart -->

    <!-- Footer -->
    <footer class="footer text-white " style="margin-left: -20px;">
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