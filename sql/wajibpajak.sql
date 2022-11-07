-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 07, 2022 at 06:24 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpp-pajak`
--

-- --------------------------------------------------------

--
-- Table structure for table `wajibpajak`
--

CREATE TABLE `wajibpajak` (
  `id` int(11) NOT NULL,
  `npwp` char(40) DEFAULT NULL,
  `bps` char(34) DEFAULT NULL,
  `tgl_spt` date DEFAULT NULL,
  `nilai_lb` char(15) DEFAULT NULL,
  `masa_pajak` date DEFAULT NULL,
  `jenis` varchar(200) DEFAULT NULL,
  `sumber` varchar(200) DEFAULT NULL,
  `pembetulan` varchar(100) DEFAULT NULL,
  `tgl_terima` date DEFAULT NULL,
  `tgl_tahap_1` date DEFAULT NULL,
  `tgl_tahap_2` date DEFAULT NULL,
  `petugas` varchar(400) DEFAULT NULL,
  `ket` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wajibpajak`
--
ALTER TABLE `wajibpajak`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bps` (`bps`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wajibpajak`
--
ALTER TABLE `wajibpajak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
