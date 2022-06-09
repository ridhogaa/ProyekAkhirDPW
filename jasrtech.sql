-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2022 at 09:52 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jasrtech`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `email`, `no_telp`, `password`) VALUES
(1, 'jovian@gmail.com', '082251196000', '1234'),
(2, 'ridho@gmail.com', '082140005119', '1234'),
(3, 'jovan@gmail.com', '082130005119', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_keranjang` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'Cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detailorder`
--

CREATE TABLE `detailorder` (
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fullprofile`
--

CREATE TABLE `fullprofile` (
  `id_profile` int(11) NOT NULL,
  `fullname` varchar(35) NOT NULL,
  `username` varchar(12) NOT NULL,
  `address-name` varchar(20) NOT NULL,
  `fulladdress` text NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `katproduk` varchar(50) NOT NULL,
  `namaproduk` text NOT NULL,
  `gambar` text NOT NULL,
  `deskripsi` text NOT NULL,
  `beratproduk` int(11) NOT NULL,
  `stokproduk` int(11) NOT NULL,
  `hargaproduk` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `katproduk`, `namaproduk`, `gambar`, `deskripsi`, `beratproduk`, `stokproduk`, `hargaproduk`, `id_akun`) VALUES
(1, 'Anime', 'Vtuber Dakimakura', 'img-upload/16PAuObByViwo.jpg', 'Dakimakura Vtuber', 1, 4, 100000, 1),
(2, 'Anime', 'Anime Dakimakura', 'img-upload/16PAuObByViwo.png', 'Dakimakura Anime', 1, 6, 125000, 1),
(3, 'Anime', 'Foto Vtuber', 'img-upload/16.b4iym3VzHs.jpg', 'Foto Vtuber', 1, 10, 120000, 1),
(4, 'Anime', 'Buku Anime', 'img-upload/16H5NaHe6oMHU.jpg', 'Buku Anime', 1, 10, 110000, 2),
(5, 'Anime', 'Bantal Anime', 'img-upload/16DmnJDVL.en6.jpg', 'Anime Pillow', 1, 9, 80000, 2),
(6, 'Normal', 'Foto Normal', 'img-upload/16MS.goSFlKmA.jpg', 'Foto Normal', 1, 8, 60000, 2),
(7, 'Foto', 'Meme Amelia', 'img-upload/16.b4iym3VzHs.jpg', 'Foto Meme Amelia', 1, 10, 70000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reseller`
--

CREATE TABLE `reseller` (
  `id_reseller` int(11) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `nama_toko` varchar(30) NOT NULL,
  `nama_domain` varchar(30) NOT NULL,
  `alamat_toko` text NOT NULL,
  `id_akun` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reseller`
--

INSERT INTO `reseller` (`id_reseller`, `no_telp`, `nama_toko`, `nama_domain`, `alamat_toko`, `id_akun`, `saldo`) VALUES
(1, '082251196000', 'Panthera', 'panthera.com ', 'Jakarta Pusat', 1, 1100000),
(2, '082140005119', 'Ryzen', 'ryzen.com ', 'Jakarta Utara', 2, 200000),
(3, '082130005119', 'Ricardo', 'ricardo.com ', 'Jakarta Timur', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` text NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_produk`, `nama_produk`, `kuantitas`, `nominal`, `id_penjual`, `id_akun`) VALUES
(19, 1, 'Vtuber Dakimakura', 2, 200000, 1, 3),
(20, 5, 'Bantal Anime', 1, 80000, 2, 3),
(21, 6, 'Foto Normal', 2, 120000, 2, 3),
(22, 1, 'Vtuber Dakimakura', 4, 400000, 1, 1),
(23, 2, 'Anime Dakimakura', 4, 500000, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indexes for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `fullprofile`
--
ALTER TABLE `fullprofile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `reseller`
--
ALTER TABLE `reseller`
  ADD PRIMARY KEY (`id_reseller`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `detailorder`
--
ALTER TABLE `detailorder`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `fullprofile`
--
ALTER TABLE `fullprofile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reseller`
--
ALTER TABLE `reseller`
  MODIFY `id_reseller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
