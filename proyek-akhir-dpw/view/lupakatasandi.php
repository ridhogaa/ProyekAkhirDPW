<?php 
    require '../connection/connection.php';

    if (isset($_POST["update"]) ) {
        $email = $_POST["email"];
        $password = $_POST["passwordbaru"];
        $cpassword = $_POST["cpasswordbaru"];
        $result = mysqli_query($conn, "SELECT * FROM akun where email = '$email'");
        
        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if(strcmp($password, $cpassword) === 0){
                $queryUpdate = mysqli_query($conn, "UPDATE akun SET password = '$password' WHERE email = '$email'");
                echo "<script> alert ('Berhasil Update Password!');
                    window.location.href='masuk.php'
                    </script>";
            } else {
                echo "<script> alert ('Gagal Update Password!'); </script>";
            }
        }
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
        <!-- Lupa Kata Sandi -->
        <div class="lupakatasandi fixed-top" id="lupakatasandi">
            <a href="index.php">
                <img class="icon-jasrtech d-flex" src="../assets/img/jasrtech.png" alt="">
            </a>
            <div class="text-center my-4">
                <span class="lupakatasandi-2 fw-bold">Atur ulang kata sandi</span><br>
            </div> 

            <form action="" method="POST">
                <label class="email" for="email">Email</label><br>
                <input class="form-control my-1" type="text" id="email" name="email" autocomplete="off">
                <label class="passwordbaru" for="passwordbaru">Password Baru</label><br>
                <input class="form-control my-1" type="password" id="passwordbaru" name="passwordbaru" autocomplete="off">
                <label class="cpasswordbaru" for="cpasswordbaru">Confirm Password Baru</label><br>
                <input class="form-control my-1" type="password" id="cpasswordbaru" name="cpasswordbaru" autocomplete="off">
                <a href="masuk.php">
                    <button class="btn-ok mt-2 text-white" type="submit" name="update">UPDATE</button>
                </a>
            </form>
        </div>  
        <!-- Akhir Lupa Kata Sandi -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

        <script src="../js/script.js"></script>
    </body>
</html>