-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 07:58 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cf`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `kode_gejala` varchar(10) NOT NULL,
  `nama_gejala` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'G01', 'Kuku sapi luka'),
(2, 'G02', 'Mulut luka'),
(3, 'G03', 'Dehidrasi'),
(4, 'G04', 'nafsu makan menurun'),
(5, 'G05', 'keluar darah dari lubang kumlah'),
(6, 'G06', 'sapi lesu'),
(7, 'G07', 'keluar lendir dari hidung dan mulut'),
(8, 'G08', 'bintik-bintik pada permukaan kulit'),
(9, 'G09', 'sapi sering garuk-garuk'),
(10, 'G10', 'berat badan menurun'),
(11, 'G11', 'Sapi sulit bernafas'),
(12, 'G12', 'demam tinggi(> 38°C)'),
(13, 'G13', 'tubuh sapi gemetar'),
(14, 'G14', 'berjalan sempoyongan'),
(15, 'G15', 'keluar cairan dari hidung dan mata'),
(16, 'G16', 'air liur terus menetes'),
(17, 'G17', 'diare/mencret'),
(18, 'G18', 'Kejang'),
(19, 'G19', 'Bulu Rontok');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `kode_penyakit` varchar(10) NOT NULL,
  `nama_penyakit` varchar(40) NOT NULL,
  `deskripsi` text NOT NULL,
  `pengobatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `deskripsi`, `pengobatan`) VALUES
(1, 'P01', 'Penyakit Mulut dan Kuku (PMK)', '', ''),
(2, 'P02', 'Penyakit Antraks', '', 'Pemberian Vaksin Spora Antraks'),
(3, 'P03', 'Demam 3 Hari', '', 'Pemberian Antibiotika dan Vitamin'),
(4, 'P04', 'Scabies', '-', 'Kulit yang luka diolesi dengan Benzoas Bensilikus 10 %\r\nDisemprot/ direndam dengan BHC 0,05 % atau Coumaphos 0,05 sampai 1 %\r\nIvermectin (Ivomec), diberikan secara Subcutan\r\nSalep Coumaphos 1 – 2 % (dalam vaselin)\r\nSalep belerang 5 % (5 gram bubuk belerang + 100 gram vaselin)'),
(5, 'P05', 'Penyakit Sapi Ngorok', '', 'Vaksin antibiotika Streptomisin, khloramfenikol, teramisin dan sejenisnya'),
(6, 'P06', 'Penyakit Ingusan', '', 'belum ada pengobatan efekti, dianjurkan untuk dipotong'),
(7, 'P07', 'Penyakit Surra', '', 'Pemberian 10 % Naganol dengan dosis pengobatan 3 gram/ekor intravena; \r\nMoranyl 10 mg/ Kg berat badan; \r\nAntrycide/ Quinapiramine 3 –5 mg/ Kg berat badan; \r\nBerenil 3,5 mg/ Kg berat badan');

-- --------------------------------------------------------

--
-- Table structure for table `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `kode_penyakit` varchar(10) NOT NULL,
  `kode_gejala` varchar(10) NOT NULL,
  `mb` float NOT NULL,
  `md` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rule`
--

INSERT INTO `rule` (`id_rule`, `kode_penyakit`, `kode_gejala`, `mb`, `md`) VALUES
(1, 'P01', 'G01', 0.9, 0.12),
(2, 'P01', 'G02', 0.88, 0.1),
(3, 'P01', 'G03', 0.8, 0.14),
(4, 'P01', 'G04', 0.74, 0.15),
(5, 'P01', 'G05', 0.8, 0.12),
(6, 'P02', 'G12', 0.7, 0.12),
(7, 'P02', 'G04', 0.7, 0.13),
(8, 'P02', 'G05', 0.9, 0.1),
(9, 'P02', 'G06', 0.78, 0.14),
(10, 'P02', 'G07', 0.78, 0.13),
(11, 'P02', 'G11', 0.8, 0.14),
(12, 'P02', 'G13', 0.75, 0.13),
(13, 'P03', 'G06', 0.7, 0.14),
(14, 'P03', 'G11', 0.72, 0.14),
(15, 'P03', 'G15', 0.75, 0.13),
(16, 'P03', 'G12', 0.89, 0.1),
(17, 'P03', 'G14', 0.78, 0.14),
(18, 'P04', 'G09', 0.89, 0.1),
(19, 'P04', 'G08', 0.89, 0.1),
(20, 'P04', 'G04', 0.75, 0.13),
(21, 'P04', 'G10', 0.7, 0.12),
(22, 'P04', 'G06', 0.65, 0.12),
(23, 'P05', 'G06', 0.7, 0.13),
(24, 'P05', 'G12', 0.75, 0.14),
(25, 'P05', 'G13', 0.7, 0.13),
(26, 'P05', 'G04', 0.73, 0.12),
(27, 'P06', 'G12', 0.74, 0.13),
(28, 'P06', 'G15', 0.83, 0.12),
(29, 'P06', 'G10', 0.72, 0.11),
(30, 'P06', 'G17', 0.86, 0.1),
(31, 'P06', 'G14', 0.73, 0.13),
(32, 'P07', 'G12', 0.76, 0.12),
(33, 'P07', 'G04', 0.78, 0.13),
(34, 'P07', 'G06', 0.8, 0.13),
(35, 'P07', 'G15', 0.73, 0.11),
(36, 'P07', 'G18', 0.84, 0.1),
(37, 'P07', 'G19', 0.86, 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `nama`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', 'Administrator'),
(2, 'user', '6ad14ba9986e3615423dfca256d04e3f', 'user', 'User Burhanudin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`),
  ADD UNIQUE KEY `kode_gejala` (`kode_gejala`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`),
  ADD UNIQUE KEY `kode_penyakit` (`kode_penyakit`);

--
-- Indexes for table `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `kode_penyakit` (`kode_penyakit`),
  ADD KEY `kode_gejala` (`kode_gejala`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`kode_penyakit`) REFERENCES `penyakit` (`kode_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rule_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `gejala` (`kode_gejala`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
