-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 12:31 PM
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
  `ongkir` int(11) DEFAULT NULL,
  `status_pengiriman` enum('Diproses','Dikirim','Sampai') DEFAULT 'Diproses',
  `dibatalkan` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `produk_id`, `nama_pembeli`, `alamat`, `no_hp`, `jumlah`, `total`, `tanggal_pesan`, `metode_pembayaran`, `kota`, `ongkir`, `status_pengiriman`, `dibatalkan`) VALUES
(26, 14, 'sri wahyuni', 'Kavling lama blok m no 10', '081266454459', 1, 75000, '2025-07-09', 'cod', 'Batam', 10000, 'Diproses', 0),
(27, 15, 'sri wahyuni', 'Kavling lama blok m no 10', '081266454459', 1, 80000, '2025-07-09', 'cod', 'Batam', 10000, 'Diproses', 0);

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
(16, 7, 'Putri Salju Lembut 500g', 70000, '../image/Putri Salju Lembut.jpg', 'Kue salju manis, lembut dan lumer di mulut dengan taburan gula halus.', 'tersedia', 6),
(17, 8, 'Brownies Kukus Coklat', 65000, '../image/Brownies Kukus Coklat.jpg', 'Brownies moist dengan coklat lumer dan topping keju/coklat leleh.', 'tersedia', 2),
(18, 8, 'Donat Kentang Mini isi 12', 40000, '../image/Donat Kentang Mini isi 12.jpg', 'Donat lembut dari kentang, mini size, diberi topping gula halus.\r\n\r\n*Pengiriman hanya berlaku untuk wilayah Batam', 'tersedia', 3),
(19, 8, 'Lapis Legit Slice (3 pcs)', 45000, '../image/Lapis Legit Slice (3 pcs).jpg', 'Kue lapis legit, harum rempah-rempah, cocok untuk suguhan premium.', 'tersedia', 3),
(20, 13, 'Keripik Pisang Coklat 250g', 25000, '../image/Keripik Pisang Coklat.jpg', 'Pisang iris tipis digoreng renyah, dilapisi coklat manis.', 'habis', 0),
(21, 13, 'Kacang Bawang Gurih 500g', 35000, '../image/Kacang Bawang Gurih.jpg', 'Kacang goreng dengan bawang, gurih dan wangi khas rumahan.', 'tersedia', 1),
(22, 13, 'Rempeyek Kacang 10 pcs', 30000, '../image/Rempeyek Kacang.jpg', 'Rempeyek tipis dan garing dengan kacang tanah melimpah.', 'tersedia', 10),
(23, 11, 'Hampers Lebaran Spesial ', 250000, '../image/Hampers Lebaran Spesial.jpg', 'Paket 3 toples kue kering + kartu ucapan dalam box eksklusif.\r\nIsi Paket:\r\nNastar Premium\r\n– Kue isi selai nanas homemade, lumer di mulut\r\nPutri Salju\r\n– Kue bulan sabit lembut dengan baluran gula halus\r\nKastengel Gurih\r\n– Kue keju asin dengan taburan keju parut yang wangi dan renyah', 'tersedia', 15),
(24, 11, 'Mini Hampers Kue Basah', 450000, '../image/Mini Hampers Kue Basah.jpg', '50 pcs kue basah, dikemas eksklusif untuk hantaran atau hadiah.', 'tersedia', 3),
(25, 12, 'Kue Ultah Cokelat Lapis', 120000, '../image/Kue Ultah Cokelat Lapis.jpg', 'Ukuran 18cm\r\nKue ulang tahun rasa cokelat lembut, dihias dengan krim dan cokelat leleh. Cocok untuk kejutan manis!\r\nPengiriman hanya berlaku untuk wilayah Batam', 'tersedia', 5),
(26, 12, 'Kue Ulang Tahun stroberi', 150000, '../image/stroberi.jpg', 'Rayakan momen spesial dengan kue ulang tahun stroberi yang lembut dan menggoda! Terbuat dari sponge cake vanilla yang super moist, dilapisi krim stroberi segar dan topping buah stroberi asli. Tampilan cantik, rasa nikmat, dan cocok untuk segala usia!\r\nUkuran tersedia: Diameter 16 cm / 20 cm (bisa custom)\r\nPengiriman hanya berlaku untuk wilayah Batam', 'habis', 5),
(27, 12, 'Peach Cake Series', 130000, '../image/Peach Cake Series.jpg', 'Selalu fresh karena dibuat setiap hari tanpa pengawet dari bahan premium dengan dekorasi cantik diatasnya.\r\nTersedia ukuran 8 Inchi (20cm) dan 10 Inchi (25cm).\r\n• Dilengkapi dengan pisau plastik dan lilin.\r\n• Dapat dilengkapi dengan papan ucapan (mohon lampirkan ucapan pada saat pemesanan).\r\n\r\nPengiriman hanya berlaku untuk wilayah Batam', 'tersedia', 4),
(28, 13, 'Cemilan Kerupuk Pedas 250gr', 15000, '../image/Cemilan Kerupuk Pedas 250gr.jpg', 'Kerupuk seblak kering plus daun jeruk dengan rasa pedasnya yang so pasti bikin kamu gak bisa berhenti ngunyah.', 'tersedia', 35),
(29, 7, 'Kue Bawang Renyah 500g', 25000, '../image/Kue bawang.jpg', 'Camilan gurih yang renyah dan bikin nagih! Dibuat dari bahan pilihan dengan rasa bawang yang khas. Cocok untuk teman santai atau suguhan keluarga.', 'tersedia', 15),
(32, 8, 'Kue Dadar Gulung (10pcs)', 45000, '../image/Kue Dadar Gulung.jpg', 'Kue Dadar Gulung merupakan kue  yang terbuat dari bahan berkualitas dan kelapa muda pilihan serta diproses higienis, makanan ini diminati dari anak-anak hingga orang tua untuk teman kopi atau teh.', 'tersedia', 3),
(33, 13, 'Basreng 100 gram', 45000, '../image/basreng.jpg', 'Camilan favorit sejuta umat! Basreng (Bakso Goreng) ini terbuat dari irisan bakso pilihan yang digoreng kering hingga renyah, lalu dibalur dengan bumbu pedas gurih khas yang menggugah selera. Cocok dinikmati kapan saja – saat nonton, belajar, atau nongkrong bareng teman!', 'tersedia', 20),
(34, 12, 'Kue Scuro', 300000, '../image/Scuro.jpg', 'Nikmati sensasi premium dari Kue Scuro, cake cokelat pekat dengan tekstur super moist dan lapisan ganache mewah yang lumer di mulut. Nama Scuro, yang berarti \"gelap\" dalam bahasa Italia, menggambarkan kelezatan cokelat intens yang cocok untuk pecinta rasa rich dan elegan.\r\nPengiriman hanya berlaku untuk wilayah Batam', 'tersedia', 6),
(36, 7, 'Kue Lidah Kucing 300 gram', 45000, '../image/Lidah Kucing.jpg', 'Nikmati kelembutan klasik dari Kue Lidah Kucing, kue kering khas yang berbentuk pipih dan panjang, dengan tekstur renyah di luar dan sedikit lumer saat digigit. Dibuat dari campuran mentega premium dan putih telur, menghasilkan rasa manis gurih yang elegan!', 'tersedia', 6),
(37, 7, 'kue sagu keju 250gr ', 35000, '../image/kue sagu.jpg', 'Cita rasa tradisional yang tak pernah gagal! Kue Sagu Keju dibuat dari tepung sagu asli dan parutan keju cheddar pilihan, menghasilkan tekstur yang ringan, renyah di luar, dan langsung lumer saat digigit. Wangi pandan atau santannya membuat setiap gigitannya bikin nagih!', 'tersedia', 6),
(38, 7, 'Cornflakes Coklat 200 gram', 28000, '../image/kue cornflakes coklat.jpg', 'Perpaduan sempurna antara cornflakes renyah dan cokelat premium yang lumer di lidah! Kue ini tidak dipanggang, tapi dicampur dan dibentuk dengan lelehan cokelat yang memberikan sensasi krispi manis di setiap gigitannya. Cocok untuk cemilan, suguhan, hingga hampers!', 'tersedia', 29),
(39, 8, 'Pisang Rai 1 box isi 5 potong ', 15000, '../image/Pisang Rai.jpg', 'Pisang Rai adalah jajanan tradisional khas Bali yang dibuat dari pisang matang yang dibalut dengan adonan tepung beras, kemudian direbus dan digulingkan dalam kelapa parut. Memiliki rasa manis alami dari pisang, gurih dari kelapa, dan tekstur kenyal yang menggugah selera.\r\nPengiriman hanya berlaku untuk wilayah Batam\r\n\r\n', 'tersedia', 7),
(40, 12, 'Kue Mocca ', 200000, '../image/cakemocca.jpg', 'Bolu chocolate dengan filling fresh cream mocca dua layer dan dicover dengan fresh cream mocca dengan hiasan chocolate dan buah kering serta kacang-kacangan diatasnya.\r\nVariasi Produk: Diameter 8 Inch (20cm)', 'tersedia', 6),
(41, 13, 'Usus Crispy 100 gram', 15000, '../image/ususcamilan.jpg', 'Camilan favorit yang nggak pernah sepi penggemar! Usus ayam goreng crispy ini diolah dari usus segar yang dibumbui rempah pilihan, kemudian digoreng kering hingga super renyah. Cocok disantap langsung sebagai camilan, lauk, atau topping nasi dan mie!', 'tersedia', 30),
(42, 13, 'Cuangki 1 pcs', 15000, '../image/cuangki.jpg', 'Cuangki adalah sajian khas Bandung yang mirip dengan bakso, namun dengan kuah yang lebih ringan dan isian yang beragam. Berisi perpaduan tahu, siomay, bakso, dan pangsit, disajikan dalam kuah kaldu gurih yang nikmat disantap hangat-hangat.\r\n\r\nIsi dalam 1 porsi:\r\nTahu isi\r\nSiomay\r\nBakso kecil\r\nPangsit rebus atau goreng\r\nKuah kaldu gurih\r\nSambal & kecap (terpisah)', 'tersedia', 45),
(43, 13, 'seblak instan 1 pcs', 14000, '../image/seblak.jpg', 'Seblak adalah masakan khas Sunda yang dikenal berasal dari wilayah Parahyangan dengan cita rasa gurih dan pedas. Terbuat dari kerupuk basah yang dimasak dengan sayuran dan sumber protein seperti telur, ayam, boga bahari, atau olahan daging sapi, dan dimasak dengan kencur.', 'tersedia', 30),
(44, 13, 'Lukcub Thai Buah', 20000, '../image/lukcup.jpg', 'Hadirkan keunikan kue khas Thailand dalam bentuk buah-buahan mini yang menggemaskan! Lukcub (Luk Chup) dibuat dari kacang hijau halus dan dibentuk menyerupai buah-buahan asli seperti mangga, wortel, terong, apel, hingga cabai. Lembut, manis, dan cocok untuk semua usia!\r\n1 box isi ±18–20 pcs ', 'tersedia', 20),
(45, 7, 'Cookies Choco Chip 250 gram', 30000, '../image/Cookies Choco Chip.jpg', 'Nikmati camilan klasik yang tak pernah gagal! Cookies Choco Chip ini dibuat dari adonan butter premium dengan taburan chocolate chip melimpah. Teksturnya pas: renyah di pinggir, lembut di tengah, dan rasa manisnya bikin nagih.', 'tersedia', 7),
(46, 8, 'Kue Lumpur Paandaan 10 pcs', 15000, '../image/Kue Lumpur.png', 'Kue tradisional yang tampil menawan! Kue Lumpur Pandan Hias ini dibuat dari campuran kentang, santan, dan pandan, menghasilkan tekstur lembut dan rasa gurih manis yang khas. Dihias cantik dengan topping santan putih dan aksen daun pandan serta selasih merah di atasnya — cocok untuk suguhan acara atau snack box elegan.', 'tersedia', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
