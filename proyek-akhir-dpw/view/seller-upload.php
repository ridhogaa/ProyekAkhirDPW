<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }
    require '../connection/connection.php';
    if(isset($_POST["simpan"])) {
        $namaproduk=$_POST['namaproduk'];
        $katproduk=$_POST['katproduk'];
        $hargaproduk=$_POST['hargaproduk'];
        $stokproduk=$_POST['stokproduk'];
        $beratproduk=$_POST['beratproduk'];
        $desproduk=$_POST['desproduk'];
    
        $nama_file = $_FILES['uploadgambar']['name'];
        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $random = crypt($nama_file, time());
        $ukuran_file = $_FILES['uploadgambar']['size'];
        $tipe_file = $_FILES['uploadgambar']['type'];
        $tmp_file = $_FILES['uploadgambar']['tmp_name'];
        $path = "img-upload/".$random.'.'.$ext;
        $pathdb = "img-upload/".$random.'.'.$ext;
        
        if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){
            if($ukuran_file <= 5000000){ 
                if(move_uploaded_file($tmp_file, $path)){ 
              
                $query = "insert into produk values('','$katproduk','$namaproduk','$pathdb','$desproduk','$beratproduk','$stokproduk','$hargaproduk', '{$_SESSION["id_akun"]}')";
                $sql = mysqli_query($conn, $query); // Eksekusi/ Jalankan query dari variabel $query
                echo "<script> alert ('Produk Berhasil Ditambahkan!');
                    window.location.href='product-seller.php'
                </script>";
                
                    if($sql){ 
                  
                        echo "<br><meta http-equiv='refresh' content='5; URL=seller-upload.php'> You will be redirected to the form in 5 seconds";
                      
                    }else{
                    // Jika Gagal, Lakukan :
                    echo "Sorry, there's a problem while submitting.";
                    echo "<br><meta http-equiv='refresh' content='5; URL=seller-upload.php'> You will be redirected to the form in 5 seconds";
                    }   
                }else{
                    // Jika gambar gagal diupload, Lakukan :
                    echo "Sorry, there's a problem while uploading the file.";
                    echo "<br><meta http-equiv='refresh' content='5; URL=seller-upload.php'> You will be redirected to the form in 5 seconds";
                }
            }else{
              // Jika ukuran file lebih dari 1MB, lakukan :
              echo "Sorry, the file size is not allowed to more than 1mb";
              echo "<br><meta http-equiv='refresh' content='5; URL=seller-upload.php'> You will be redirected to the form in 5 seconds";
            }
        }else{
            // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
            echo "Sorry, the image format should be JPG/PNG.";
            echo "<br><meta http-equiv='refresh' content='5; URL=seller-upload.php'> You will be redirected to the form in 5 seconds";
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
            <a class="navbar-brand" href="product-seller.php" onclick="reloadOn()">JASR Tech Seller</a>
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

    <!-- Pembeli -->
    <!-- <div class="pembeli-penjual d-flex align-items-center d-flex-column" id="pembeli-penjual">
        <div class="pembeli-penjual-2 d-flex">
            <img class="icon-seller nav-link me-2" src="../assets/img/shop.png" alt="" style="float:left;">
            <span class="m-auto fw-bold"></span><br>
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
    <!-- Akhir Pembeli -->

    <!-- Seller Upload -->
    <div class="seller-upload pt-5">
        <div>
            <h3>Seller</h3>
            <hr class="horizontal position-relative" style="top:8px; margin-left: 68px; width:90%; color: #446CB3;">
        </div>
        <div class="upload">
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">
                    <img src="../assets/img/user-2.png" alt=""><span
                        class="me-5"><?php echo $_SESSION['namatoko']; ?></span>
                    <hr>
                    <div class="foto">
                        <label class="upload-foto mt-3" for="upload-foto">Upload Foto Produk (*)</label>
                        <div class="row">
                            <input name="uploadgambar" class="my-3" type="file" id="upload-foto" accept=""
                                style="border: none;">
                        </div>
                    </div>

                    <table>
                        <label class="mt-3" for="">Informasi Produk (*)</label>
                        <hr>
                        <tr>
                            <td><label class="nama-produk" for="nama-produk">Nama Produk &emsp;:</label></td>
                            <td><input name="namaproduk" class="form-control" type="text" id="nama-produk"><br></td>
                        </tr>
                        <tr>
                            <td><label class="kategori-produk" for="kategori-produk">Kategori Produk :</label></td>
                            <td><input name="katproduk" class="form-control" type="text" id="kategori-produk"><br></td>
                        </tr>
                    </table>

                    <table>
                        <label class="mt-3" for="">Informasi Produk (*)</label>
                        <hr>
                        <tr>
                            <td><label class="harga" for="harga">Harga &emsp;&ensp;&emsp;&emsp;&emsp;:</label></td>
                            <td><input name="hargaproduk" class="form-control" type="text" id="harga"><br></td>
                        </tr>
                        <tr>
                            <td><label class="stok" for="stok">Stok &emsp;&emsp;&nbsp;&emsp;&emsp;&emsp;:</label></td>
                            <td><input name="stokproduk" class="form-control" type="text" id="stok"><br></td>
                        </tr>

                        <tr>
                            <td><label class="berat" for="berat">Berat &emsp;&ensp;&nbsp;&emsp;&emsp;&emsp;:</label>
                            </td>
                            <td><input name="beratproduk" class="form-control" type="text" id="berat"><br></td>
                        </tr>
                        <tr>
                            <td><label class="deskripsi" for="deskripsi">Deskripsi &emsp;&emsp;&emsp;:</label></td>
                            <td><input name="desproduk" class="form-control" type="text" id="deskripsi"><br></td>
                        </tr>
                    </table>

                    <button name="simpan" style="border-radius: 10px; border: none; background-color: #446CB3;"
                        class="btn btn-simpan text-white mt-2" type="submit">Simpan</button>
                    <button style="border-radius: 10px; border: none; background-color: #446CB3;"
                        class="btn btn-batal text-white mt-2" type="button">Batal</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Akhir Seller Upload -->

    <!-- Footer -->
    <footer class="footer footer-seller-upload text-white">
        <div class="info container-fluid d-flex">
            <span class="indonesia ms-2">ID - Indonesia</span>
            <div class="tentang ms-auto">
                <a class="me-3" href="">Tentang Kami</a>
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