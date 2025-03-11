-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 01:29 AM
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
-- Database: `presensi_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `status` enum('Hadir','Sakit','Terlambat','Alpha') NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `siswa_id`, `status`, `tanggal`, `foto`) VALUES
(19, 13003, 'Sakit', '2025-02-17 03:25:15', NULL),
(20, 13004, 'Terlambat', '2025-02-17 03:34:39', NULL),
(21, 13005, 'Terlambat', '2025-02-17 03:34:42', NULL),
(22, 13006, 'Sakit', '2025-02-17 03:34:45', NULL),
(23, 13007, 'Hadir', '2025-02-17 03:34:49', NULL),
(24, 13003, 'Hadir', '2025-02-20 12:58:25', NULL),
(25, 13004, 'Sakit', '2025-02-20 12:59:50', NULL),
(26, 13005, 'Terlambat', '2025-02-20 13:03:17', NULL),
(27, 13006, 'Sakit', '2025-02-20 13:28:48', NULL),
(28, 13007, 'Alpha', '2025-02-20 13:37:46', NULL),
(29, 13008, 'Alpha', '2025-02-20 13:39:22', NULL),
(30, 13006, 'Terlambat', '2025-02-20 13:51:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `kelas`, `jurusan`, `foto`, `nis`) VALUES
(13003, 'AMYATUL JANAH', 'XI', 'RPL', 'WhatsApp Image 2025-02-11 at 07.48.19_39ba1231.jpg', '12967'),
(13004, 'CHAYLAROSSA SURYANA PUTRI', 'XI', 'RPL', 'oca.jpg', '12971'),
(13005, 'CHIKA INDIRA PUTRI', 'XI', 'RPL', 'cika.jpg', '12972'),
(13006, 'DAVINA MAHARANI', 'XI', 'RPL', 'dapina.jpg', '12973'),
(13007, 'DESTIANA', 'XI', 'RPL', 'des.jpg', '12974'),
(13008, 'THASYA FELISHA DESPAT', 'XI', 'RPL', 'tasa.jpg', '13000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13009;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
