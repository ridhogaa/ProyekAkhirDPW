<?php
    session_start();
    if (isset($_SESSION["login"])) {
        header("Location: homepage-pembeli.php");
        exit;
    }
    
    require '../connection/connection.php';
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
                $_SESSION["login"] = true;
                $_SESSION["id_akun"] = $row['id_akun'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["password"] = $row['password'];
                $_SESSION['namatoko'] = $row2['nama_toko'];
                echo "<script> alert ('Berhasil Login');
                window.location.href='homepage-pembeli.php'
                </script>";
                
                exit;
            } 
        } else {
            echo "<script> alert ('Gagal Login');
            window.location.href='index.php'
            </script>";
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

<body class="bg-masuk-daftar-lupakatasandi">
    <!-- Masuk -->
    <div class="masukk fixed-top" id="masukk">
        <a href="index.php">
            <img class="icon-jasrtech d-flex" src="../assets/img/jasrtech.png" alt="">
        </a>
        <div class="d-flex justify-content-between my-4">
            <span class="masuk-2 fw-bold">Masuk</span>
            <a href="daftar.php">Daftar</a>
        </div>

        <form action="" method="POST">
            <label class="nomorhp-email" for="nomorhp-email">Nomor HP atau Email</label><br>
            <input class="form-control my-1" type="text" id="nomorhp-email" name="nomorhp-email" autocomplete="off">
            <label class="password" for="password">Password</label><br>
            <input class="form-control my-1" type="password" id="password" name="password" autocomplete="off">
            <a class="daftar-lupakatasandi d-flex justify-content-end" href="lupakatasandi.php">Lupa kata sandi?</a>
            <a href="homepage-pembeli.php">
                <button class="btn-loginn mt-2 text-white" type="submit" name="login">Login</button>
            </a>
        </form>
    </div>
    <!-- Akhir Masuk -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script src="../script.js"></script>
</body>

</html>