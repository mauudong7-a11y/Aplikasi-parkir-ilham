-- Database: ilham_parkir

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `tabel_users`
--

CREATE TABLE `tabel_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','owner') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_users`
--

INSERT INTO `tabel_users` (`nama_user`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', MD5('admin123'), 'admin'),
('Petugas Parkir', 'petugas', MD5('petugas123'), 'petugas'),
('Pemilik', 'owner', MD5('owner123'), 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kendaraan`
--

CREATE TABLE `tabel_kendaraan` (
  `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kendaraan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_kendaraan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_kendaraan`
--

INSERT INTO `tabel_kendaraan` (`nama_kendaraan`) VALUES
('Motor'),
('Mobil'),
('Truk/Bus');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_area_parkir`
--

CREATE TABLE `tabel_area_parkir` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `nama_area` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_area_parkir`
--

INSERT INTO `tabel_area_parkir` (`nama_area`, `kapasitas`) VALUES
('Lantai 1 (Motor)', 100),
('Lantai 2 (Mobil)', 50),
('Area Luar (Truk/Bus)', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tarif`
--

CREATE TABLE `tabel_tarif` (
  `id_tarif` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `tarif_per_jam` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tarif`),
  KEY `id_kendaraan` (`id_kendaraan`),
  CONSTRAINT `fk_tarif_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `tabel_kendaraan` (`id_kendaraan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_tarif`
--

INSERT INTO `tabel_tarif` (`id_kendaraan`, `tarif_per_jam`) VALUES
(1, 2000),
(2, 5000),
(3, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_transaksi`
--

CREATE TABLE `tabel_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_kendaraan` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `jam_masuk` datetime NOT NULL,
  `jam_keluar` datetime DEFAULT NULL,
  `lama_parkir` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `status` enum('masuk','keluar') NOT NULL DEFAULT 'masuk',
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_transaksi`),
  KEY `id_kendaraan` (`id_kendaraan`),
  KEY `id_area` (`id_area`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `fk_transaksi_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `tabel_kendaraan` (`id_kendaraan`),
  CONSTRAINT `fk_transaksi_area` FOREIGN KEY (`id_area`) REFERENCES `tabel_area_parkir` (`id_area`),
  CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `tabel_users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_log_aktivitas`
--

CREATE TABLE `tabel_log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `aktivitas` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`id_user`) REFERENCES `tabel_users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
