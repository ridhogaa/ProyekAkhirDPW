<?php 
    require '../connection/connection.php';
    if (isset($_POST["register"])) {

        if (registrasiAkun($_POST) > 0) {
            echo "<script> alert ('user baru berhasil ditambahkan!'); 
            window.location.href='masuk.php'
            </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
    function registrasiAkun($data){
        global $conn;
    
        $email = $data["email"];
        $nomorhp = $data["nomorhp"];
        $password = $data["password"];
    
        $result = mysqli_query($conn, "SELECT email from akun where email = '$email'");
        if (mysqli_fetch_assoc($result)) {
          echo "<script> alert ('email yang dipilih sudah terdaftar, gunakan email lain!'); </script>";
          return false;
        }
        $regex1 = preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $data["email"]);
        $regex2 = preg_match("/^[0-9]+$/", $data["nomorhp"]);
        if ($regex1 && $regex2) {
          mysqli_query($conn, "INSERT INTO akun VALUES('', '$email', '$nomorhp', '$password')");
        } else {
          echo "<script> alert ('Email atau Nomor Telfon Tidak valid!'); </script>";
          return false;
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">

        <!-- My CSS -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body class="bg-masuk-daftar-lupakatasandi">
        <!-- Daftar -->
        <div class="daftarr fixed-top" id="daftarr">
            <a href="../index.php">
                <img class="icon-jasrtech d-flex" src="../assets/img/jasrtech.png" alt="">
            </a>
            <div class="text-center my-4">
                <span class="daftar-2 fw-bold">Daftar Sekarang</span><br>
                <span class="sudahpunyaakun">Sudah punya akun? <a class="" href="masuk.php">Masuk</a></span>
            </div> 

            <form action="" method="POST">
                <label class="email" for="email">Email</label><br>
                <input class="formulir form-control my-1" type="text" id="email" name="email" autocomplete="off">
                <label class="nomorhp" for="nomorhp">Nomor HP</label><br>
                <input class="formulir form-control my-1" type="text" id="nomorhp" name="nomorhp" autocomplete="off">
                <label class="password" for="password">Password</label><br>
                <input class="formulir form-control my-1" type="password" id="password" name="password">
                <a href="masuk.php">
                    <button class="btn-daftar mt-2 text-white" type="submit" name="register">Daftar</button>
                </a>
            </form>
        </div>  
        <!-- Akhir Daftar -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

        <script src="../js/script.js"></script>
    </body>
</html>