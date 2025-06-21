-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 06:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`) VALUES
(7, '	Kue Kering'),
(8, '	Kue Basah'),
(11, '	Paket Hampers'),
(12, 'Kue Ulang Tahun'),
(13, 'Camilan');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `nama_pembeli` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `metode_pembayaran` varchar(20) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `produk_id`, `nama_pembeli`, `alamat`, `no_hp`, `jumlah`, `total`, `tanggal_pesan`, `metode_pembayaran`, `kota`, `ongkir`) VALUES
(1, 14, 'yuni', 'batam', '082182214503', 1, 85000, '2025-06-11', 'cod', 'Batam', 10000),
(5, 15, 'sri wahyuni', 'Batam', '082182214503', 2, 160000, '2025-06-11', 'cod', 'Batam', 10000),
(6, 14, 'sri wahyuni', 'Batam', '082182214503', 1, 75000, '2025-06-11', 'cod', 'Batam', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia',
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `harga`, `foto`, `detail`, `ketersediaan_stok`, `stok`) VALUES
(14, 7, 'Nastar Keju Premium 500g', 75000, '../image/nastar.jpg', 'Kue isi selai nanas dengan topping keju, tekstur lembut dan lumer.', 'tersedia', 18),
(15, 7, 'Kastengel Gurih 500g', 80000, '../image/Kastengel Gurih.jpg', 'Kue keju asin gurih khas Lebaran, renyah dan beraroma keju tajam.', 'tersedia', 8),
(16, 7, 'Putri Salju Lembut 500g', 70000, '../image/Putri Salju Lembut.jpg', 'Kue salju manis, lembut dan lumer di mulut dengan taburan gula halus.', 'habis', 0),
(17, 8, 'Brownies Kukus Coklat', 65000, '../image/Brownies Kukus Coklat.jpg', 'Brownies moist dengan coklat lumer dan topping keju/coklat leleh.', 'tersedia', 2),
(18, 8, 'Donat Kentang Mini isi 12', 40000, '../image/Donat Kentang Mini isi 12.jpg', 'Donat lembut dari kentang, mini size, diberi topping gula halus.', 'tersedia', 3),
(19, 8, 'Lapis Legit Slice (3 pcs)', 45000, '../image/Lapis Legit Slice (3 pcs).jpg', 'Kue lapis legit, harum rempah-rempah, cocok untuk suguhan premium.', 'tersedia', 3),
(20, 13, 'Keripik Pisang Coklat 250g', 25000, '../image/Keripik Pisang Coklat.jpg', 'Pisang iris tipis digoreng renyah, dilapisi coklat manis.', 'habis', 0),
(21, 13, 'Kacang Bawang Gurih 500g', 35000, '../image/Kacang Bawang Gurih.jpg', 'Kacang goreng dengan bawang, gurih dan wangi khas rumahan.', 'tersedia', 1),
(22, 13, 'Rempeyek Kacang 10 pcs', 30000, '../image/Rempeyek Kacang.jpg', 'Rempeyek tipis dan garing dengan kacang tanah melimpah.', 'tersedia', 10),
(23, 11, 'Hampers Lebaran Spesial ', 250000, '../image/Hampers Lebaran Spesial.jpg', 'Paket 3 toples kue kering + kartu ucapan dalam box eksklusif.', 'tersedia', 15),
(24, 11, 'Mini Hampers Kue Basah', 450000, '../image/Mini Hampers Kue Basah.jpg', '50 pcs kue basah, dikemas eksklusif untuk hantaran atau hadiah.', 'tersedia', 3),
(25, 12, 'Kue Ultah Cokelat Lapis', 120000, '../image/Kue Ultah Cokelat Lapis.jpg', 'Ukuran 18cm\r\nKue ulang tahun rasa cokelat lembut, dihias dengan krim dan cokelat leleh. Cocok untuk kejutan manis!', 'tersedia', 5),
(26, 12, 'Kue Ulang Tahun ', 150000, '../image/Kue Ulang Tahun Anak Tema Kartun.jpg', 'Ukuran 18cm\r\nCustom cake dengan dekorasi sesuai dengan gambar', 'habis', 0),
(27, 12, 'Kue Tart Stroberi Keju', 130000, '../image/Kue Tart Stroberi Keju.jpg', 'Perpaduan manis stroberi segar dan gurih keju parut di atas sponge cake lembut.', 'tersedia', 4),
(28, 13, 'Cemilan Kerupuk Pedas 250gr', 15000, '../image/Cemilan Kerupuk Pedas 250gr.jpg', 'Kerupuk seblak kering plus daun jeruk dengan rasa pedasnya yang so pasti bikin kamu gak bisa berhenti ngunyah.', 'tersedia', 35),
(29, 7, 'Kue Bawang Renyah 500g', 25000, '../image/Kue bawang.jpg', 'Camilan gurih yang renyah dan bikin nagih! Dibuat dari bahan pilihan dengan rasa bawang yang khas. Cocok untuk teman santai atau suguhan keluarga.', 'tersedia', 15),
(31, 12, 'Peach Cake Series', 250000, '../image/Peach Cake.jpg', 'Selalu fresh karena dibuat setiap hari tanpa pengawet dari bahan premium dengan dekorasi cantik diatasnya.\r\nTersedia ukuran 8 Inchi (20cm) dan 10 Inchi (25cm).\r\n• Dilengkapi dengan pisau plastik dan lilin.\r\n• Dapat dilengkapi dengan papan ucapan (mohon lampirkan ucapan pada saat pemesanan).\r\n\r\n*Pengiriman hanya berlaku untuk wilayah Batam', 'tersedia', 3),
(32, 8, 'Kue Dadar Gulung (10pcs)', 45000, '../image/Dadar gulung.jpg', 'Kue Dadar Gulung merupakan kue  yang terbuat dari bahan berkualitas dan kelapa muda pilihan serta diproses higienis, makanan ini diminati dari anak-anak hingga orang tua untuk teman kopi atau teh.', 'tersedia', 3);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `metode_pembayaran` enum('cod','midtrans') NOT NULL,
  `tanggal_transaksi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'tokoutama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`kategori_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
