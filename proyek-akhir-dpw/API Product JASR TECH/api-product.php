<?php
require_once '../connection/connection.php';
  if(function_exists($_GET['function'])) {
        $_GET['function']();
  }   
  function get_produk()
  {
      global $conn;      
      $query = $conn->query("SELECT * FROM produk");            
      while($row=mysqli_fetch_object($query))
      {
        $data[] =$row;
      }
      $response=array(
                    'status' => 1,
                    'message' =>'Success',
                    'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
  }   
  
  function get_produk_id()
  {
      global $conn;
      if (!empty($_GET["id_produk"])) {
        $id = $_GET["id_produk"];      
      }            
      $query ="SELECT * FROM produk WHERE id_produk = $id";      
      $result = $conn->query($query);
      while($row = mysqli_fetch_object($result))
      {
        $data[] = $row;
      }            
      if($data)
      {
      $response = array(
                    'status' => 1,
                    'message' =>'Success',
                    'data' => $data
                  );               
      }else {
        $response=array(
                    'status' => 0,
                    'message' =>'No Data Found'
                  );
      }
      
      header('Content-Type: application/json');
      echo json_encode($response); 
  }
  function insert_produk() {
      $response = array();
      global $conn;
      $boolean = is_uploaded_file($_FILES['uploadgambar']['tmp_name']) && $_POST['id_produk'] && $_POST['namaproduk'] 
              && $_POST['katproduk'] && $_POST['hargaproduk'] 
              && $_POST['stokproduk'] && $_POST['beratproduk'] 
              && $_POST['desproduk'] && $_POST['id_akun'];
      $nama_file = $_FILES['uploadgambar']['name'];
      $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
      $random = crypt($nama_file, time());
      $ukuran_file = $_FILES['uploadgambar']['size'];
      $tipe_file = $_FILES['uploadgambar']['type'];
      $tmp_file = $_FILES['uploadgambar']['tmp_name'];
      $path = "../view/img-upload/".$random.'.'.$ext;
      $pathdb = "img-upload/".$random.'.'.$ext;
      if($boolean){
          if($tipe_file == "image/jpeg" || $tipe_file == "image/png"){
              if($ukuran_file <= 5000000){ 
                  $query = "insert into produk values
                  ('{$_POST['id_produk']}',
                  '{$_POST['katproduk']}',
                  '{$_POST['namaproduk']}',
                  '$pathdb',
                  '{$_POST['desproduk']}',
                  '{$_POST['beratproduk']}',
                  '{$_POST['stokproduk']}',
                  '{$_POST['hargaproduk']}',
                  '{$_POST['id_akun']}')";
                  $sql =  $conn->query($query);// Eksekusi/ Jalankan query dari variabel $query
                  
                      if($sql && move_uploaded_file($tmp_file, $path)){ 
                          $response["MESSAGE"] = "CREATE DATA SUCCED";
                          $response["STATUS"] = 200;

                      }else{
                          // Jika Gagal, Lakukan :
                          $response["MESSAGE"] = "CREATE DATA FAILED";
                          $response["STATUS"] = 404;
                      }  
              }else{
                  // Jika ukuran file lebih dari 1MB, lakukan :
                  $response["MESSAGE"] = "UPLOAD FAILED SIZE FILE";
                  $response["STATUS"] = 404;
              }
          }else{
              // Jika tipe file yang diupload bukan JPG / JPEG / PNG, lakukan :
              $response["MESSAGE"] = "UPLOAD FAILED TYPE FILE NOT JPG/JPEG/PNG";
              $response["STATUS"] = 404;
          }
      } else {
          $response["MESSAGE"] = "INVALID REQUEST";
          $response["STATUS"] = 400;
      }
      echo json_encode($response);
    }
  
    function update_produk()
      {
        global $conn;
        if (!empty($_GET["id_produk"])) {
        $id = $_GET["id_produk"];      
      }   
        $check = array('deskripsi' => '', 'stokproduk' => '', 'hargaproduk' => '');
        $check_match = count(array_intersect_key($_POST, $check));         
        if($check_match == count($check)){
        
              $result = mysqli_query($conn, "UPDATE produk SET 
              deskripsi = '$_POST[deskripsi]',
              stokproduk = '$_POST[stokproduk]',
              hargaproduk = '$_POST[hargaproduk]' WHERE id_produk = $id");
        
            if($result)
            {
              $response=array(
                  'status' => 1,
                  'message' =>'Update Success'                  
              );
            }
            else
            {
              $response=array(
                  'status' => 0,
                  'message' =>'Update Failed'                  
              );
            }
        }else{
            $response=array(
                    'status' => 0,
                    'message' =>'Wrong Parameter',
                    'data'=> $id
                  );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
      }
  function delete_produk()
  {
      global $conn;
      $id = $_GET['id_produk'];
      $query = "DELETE FROM produk WHERE id_produk=".$id;
      if(mysqli_query($conn, $query))
      {
        $response=array(
            'status' => 1,
            'message' =>'Delete Success'
        );
      }
      else
      {
        $response=array(
            'status' => 0,
            'message' =>'Delete Fail.'
        );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
  }
?>