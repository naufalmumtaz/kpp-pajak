-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 07, 2022 at 06:23 AM
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
-- Table structure for table `npwp`
--

CREATE TABLE `npwp` (
  `npwp` char(40) DEFAULT NULL,
  `nama_wp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `npwp`
--

INSERT INTO `npwp` (`npwp`, `nama_wp`) VALUES
('805971603528000', 'MAJU JAYA'),
('804986693528000', 'DESA AMAN'),
('942513128528000', 'BERSAMA JAYA'),
('022461735528001', 'ABC'),
('015827686528000', 'DEF'),
('829005297528000', 'GHI'),
('612791848528000', 'JKL'),
('210226759528000', 'MNO'),
('314606906528000', 'GHJ');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
