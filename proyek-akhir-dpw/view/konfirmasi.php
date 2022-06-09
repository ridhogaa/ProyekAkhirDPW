<?php 
session_start();

require '../connection/connection.php';

function fetch_assoc($query){
    global $conn;

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

$id_akun = $_SESSION['id_akun'];


if(konfirmasi($id_akun) > 0) {
    echo "
        <script>
            alert('Pembelian Berhasil!');
            document.location.href = 'homepage-pembeli.php';
        </script>
        ";
} else {
    echo "
        <script>
            alert('Pembelian Gagal!');
            document.location.href = 'cart.php';
        </script>
    ";
}

function konfirmasi($id){
    global $conn;
    $id_pembeli = (int) $id;
    $data_o = mysqli_query($conn, "SELECT * FROM detailorder WHERE id_akun = $id_pembeli");
    foreach ( $data_o as $a ) {
        $id_order = (int) $a['id_order'];
        $id_produk = (int) $a['id_produk'];

        $data_produk = fetch_assoc("SELECT * FROM produk WHERE id_produk = $id_produk");
        $nama_produk = $data_produk['namaproduk'];
        $kuantitas = (int) $a['qty'];
        $nominal = (int) $a['harga'];
        $id_resell = (int) $data_produk['id_akun'];

        $data_penjual = fetch_assoc("SELECT * FROM reseller WHERE id_akun = $id_resell");
        $id_penjual = (int) $data_penjual['id_reseller'];
        $saldo = $data_penjual['saldo'];
        $saldo += $nominal;

        $stock_barang = (int) $data_produk['stokproduk'];

        $jumlah_baru = $stock_barang - $kuantitas;

        $query = "UPDATE reseller SET saldo = $saldo WHERE id_reseller = $id_penjual";
        mysqli_query($conn, $query);

        $query = "UPDATE produk SET stokproduk = $jumlah_baru WHERE id_produk = $id_produk";
        mysqli_query($conn, $query);

        $query = "INSERT INTO transaksi VALUES('', $id_produk, '$nama_produk',
                    $kuantitas, $nominal, $id_penjual, $id_pembeli)";
        mysqli_query($conn, $query);

        mysqli_query($conn, "DELETE FROM detailorder WHERE id_order = $id_order");
    }

    $data_c = mysqli_query($conn, "SELECT * FROM cart WHERE id_akun = $id_pembeli");
    foreach ( $data_c as $b ) {
        $id_c = $b['id_keranjang'];

        mysqli_query($conn, "DELETE FROM cart WHERE id_keranjang = $id_c");
    }

    return mysqli_affected_rows($conn);
}



?>