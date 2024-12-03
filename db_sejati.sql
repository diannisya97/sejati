-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 03:31 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sejati`
--

-- --------------------------------------------------------

--
-- Table structure for table `imt`
--

CREATE TABLE `imt` (
  `idimt` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `bb` float DEFAULT NULL,
  `tb` float DEFAULT NULL,
  `hasilimt` float DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tglperiksa` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imt`
--

INSERT INTO `imt` (`idimt`, `idsiswa`, `bb`, `tb`, `hasilimt`, `keterangan`, `tglperiksa`) VALUES
(2, 1, 73, 1.79, 22.7833, 'Normal', '2024-08-23 21:19:30'),
(3, 1, 76, 1.78, 23.9869, 'Normal', '2024-08-23 21:21:21'),
(4, 20, 75, 1.75, 24.4898, 'Normal', '2024-08-27 20:53:33'),
(5, 20, 75, 1.74, 24.7721, 'Normal', '2024-08-27 20:55:22'),
(6, NULL, 65, 1.66, 23.5883, 'Normal', '2024-08-28 21:23:10'),
(7, 17, 76, 1.68, 26.9274, 'Kelebihan Berat Badan', '2024-09-02 21:58:05'),
(8, 17, 71, 1.78, 22.4088, 'Normal', '2024-09-02 21:59:00'),
(9, 18, 78, 1.78, 24.6181, 'Normal', '2024-09-08 21:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `imtperempuan`
--

CREATE TABLE `imtperempuan` (
  `idimtperempuan` int(11) NOT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `bb` float DEFAULT NULL,
  `tb` float DEFAULT NULL,
  `hasilimtperempuan` float DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tglperiksa` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imtperempuan`
--

INSERT INTO `imtperempuan` (`idimtperempuan`, `idsiswa`, `bb`, `tb`, `hasilimtperempuan`, `keterangan`, `tglperiksa`) VALUES
(1, 3, 55, 1.57, 22.3133, 'Normal', '2024-08-23 21:04:15'),
(2, 23, 66, 1.57, 26.7759, 'Kelebihan Berat Badan', '2024-08-23 21:04:51'),
(3, 3, 69, 1.63, 25.9701, 'Kelebihan Berat Badan', '2024-08-23 21:07:27'),
(4, 3, 66, 1.69, 23.1084, 'Normal', '2024-08-23 21:11:37'),
(5, 22, 48, 1.58, 19.2277, 'Normal', '2024-08-27 20:57:54'),
(6, NULL, 76, 1.78, 23.9869, 'Normal', '2024-08-28 21:23:49'),
(7, NULL, 45, 1.56, 18.4911, 'Kurus', '2024-09-02 21:54:15'),
(8, 24, 46, 1.56, 18.902, 'Normal', '2024-09-02 21:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhanenergi`
--

CREATE TABLE `kebutuhanenergi` (
  `idenergi` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `bb` float DEFAULT NULL,
  `tb` float DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `tingkataktif` enum('tidak pernah berolahraga','jarang berolahraga','sering berolahraga') DEFAULT NULL,
  `hasil` float DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `tglperiksa` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kebutuhanenergi`
--

INSERT INTO `kebutuhanenergi` (`idenergi`, `iduser`, `bb`, `tb`, `usia`, `tingkataktif`, `hasil`, `idsiswa`, `tglperiksa`) VALUES
(2, NULL, 73, 1.79, 18, 'sering berolahraga', 3412.78, 1, '2024-08-23 21:19:30'),
(3, NULL, 76, 1.78, 19, 'jarang berolahraga', 3207.1, 1, '2024-08-23 21:21:21'),
(4, NULL, 75, 1.75, 21, 'jarang berolahraga', 3152.11, 20, '2024-08-27 20:53:34'),
(5, NULL, 75, 1.74, 21, 'tidak pernah berolahraga', 2903.64, 20, '2024-08-27 20:55:22'),
(6, 1, 65, 1.66, 21, 'tidak pernah berolahraga', 2691.24, NULL, '2024-08-28 21:23:10'),
(7, NULL, 76, 1.68, 24, 'jarang berolahraga', 3097.9, 17, '2024-09-02 21:58:05'),
(8, NULL, 71, 1.78, 24, 'jarang berolahraga', 3073.85, 17, '2024-09-02 21:59:00'),
(9, NULL, 78, 1.78, 21, 'jarang berolahraga', 3225.04, 18, '2024-09-08 21:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhanenergiperempuan`
--

CREATE TABLE `kebutuhanenergiperempuan` (
  `idenergiperempuan` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `bb` float DEFAULT NULL,
  `tb` float DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `tingkataktif` enum('tidak pernah berolahraga','jarang berolahraga','sering berolahraga') DEFAULT NULL,
  `hasil` float DEFAULT NULL,
  `tglperiksa` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kebutuhanenergiperempuan`
--

INSERT INTO `kebutuhanenergiperempuan` (`idenergiperempuan`, `iduser`, `idsiswa`, `bb`, `tb`, `usia`, `tingkataktif`, `hasil`, `tglperiksa`) VALUES
(1, NULL, 3, 55, 1.57, 17, 'tidak pernah berolahraga', 1674.84, '2024-08-23 21:04:15'),
(2, NULL, 23, 66, 1.57, 21, 'sering berolahraga', 2075.5, '2024-08-23 21:04:51'),
(3, NULL, 3, 69, 1.63, 18, 'jarang berolahraga', 1997.06, '2024-08-23 21:07:27'),
(4, NULL, 3, 66, 1.69, 20, 'jarang berolahraga', 1961.44, '2024-08-23 21:11:37'),
(5, NULL, 22, 48, 1.58, 21, 'jarang berolahraga', 1704.95, '2024-08-27 20:57:54'),
(6, 1, NULL, 76, 1.78, 22, 'tidak pernah berolahraga', 1933.92, '2024-08-28 21:23:49'),
(7, NULL, NULL, 45, 1.56, 23, 'jarang berolahraga', 1650.61, '2024-09-02 21:54:15'),
(8, NULL, 24, 46, 1.56, 23, 'jarang berolahraga', 1663.09, '2024-09-02 21:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `idkomen` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `isikomen` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `idtopik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `komentarperempuan`
--

CREATE TABLE `komentarperempuan` (
  `idkomenperempuan` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `isikomenperempuan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `idtopikperempuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komentarperempuan`
--

INSERT INTO `komentarperempuan` (`idkomenperempuan`, `iduser`, `idusersiswa`, `isikomenperempuan`, `tanggal`, `idtopikperempuan`) VALUES
(1, NULL, 2, 'coba teruss bosss\r\nsampee puasss, moga moga kuat yaw', '2024-07-24 21:57:38', 7),
(23, 1, NULL, 'asdfasd', '2024-08-12 17:36:51', 24);

-- --------------------------------------------------------

--
-- Table structure for table `kuisionerkesehatanlaki`
--

CREATE TABLE `kuisionerkesehatanlaki` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionerkesehatanlaki`
--

INSERT INTO `kuisionerkesehatanlaki` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `totalSkor`, `kategori`) VALUES
(1, 2, 0, 1, 1, 2, 2, 1, 7, 'Cukup Baik'),
(2, 15, 2, 2, 2, 2, 2, 2, 12, 'Sangat Baik'),
(3, 19, 1, 2, 1, 1, 2, 2, 9, 'Sangat Baik'),
(4, 18, 1, 1, 1, 2, 2, 2, 9, 'Sangat Baik'),
(5, 20, 1, 1, 1, 1, 1, 1, 6, 'Cukup Baik'),
(6, 2, 2, 2, 2, 2, 2, 2, 12, 'Sangat Baik'),
(7, 18, 0, 0, 0, 0, 0, 0, 0, 'Kurang Baik'),
(8, 2, 1, 1, 0, 0, 1, 2, 5, 'Cukup Baik'),
(9, NULL, 1, 1, 2, 2, 2, 2, 10, 'Sangat Baik'),
(10, NULL, 0, 1, 1, 1, 1, 2, 6, 'Cukup Baik'),
(11, 3, 2, 2, 1, 1, 2, 2, 10, 'Sangat Baik'),
(12, 13, 1, 2, 2, 1, 1, 1, 8, 'Cukup Baik'),
(13, 18, 2, 1, 1, 2, 2, 2, 10, 'Sangat Baik'),
(14, 17, 1, 1, 1, 2, 2, 1, 8, 'Cukup Baik'),
(15, 8, 0, 1, 1, 1, 1, 2, 6, 'Cukup Baik'),
(16, 18, 1, 1, 2, 1, 1, 2, 8, 'Cukup Baik'),
(17, 3, 1, 2, 2, 1, 1, 2, 9, 'Sangat Baik'),
(18, 8, 2, 2, 1, 1, 1, 2, 9, 'Sangat Baik');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionerkesehatanperempuan`
--

CREATE TABLE `kuisionerkesehatanperempuan` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `q8` int(11) DEFAULT NULL,
  `q9` int(11) DEFAULT NULL,
  `q10` int(11) DEFAULT NULL,
  `q11` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionerkesehatanperempuan`
--

INSERT INTO `kuisionerkesehatanperempuan` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `totalSkor`, `kategori`) VALUES
(1, 2, 0, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 7, 'Kurang Baik'),
(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 22, 'Sangat Baik'),
(3, 4, 1, 1, 2, 2, 1, 1, 0, 1, 1, 2, 2, 14, 'Cukup Baik'),
(4, 4, 1, 2, 1, 1, 1, 2, 1, 1, 2, 2, 2, 16, 'Sangat Baik'),
(5, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 22, 'Sangat Baik'),
(6, 22, 1, 2, 2, 0, 2, 2, 2, 2, 2, 2, 2, 19, 'Sangat Baik'),
(7, 4, 2, 1, 1, 2, 1, 1, 2, 2, 2, 2, 2, 18, 'Sangat Baik'),
(8, 22, 1, 2, 2, 0, 2, 2, 2, 2, 2, 2, 2, 19, 'Sangat Baik'),
(9, NULL, 1, 1, 1, 1, 2, 2, 0, 1, 1, 0, 1, 11, 'Cukup Baik'),
(10, NULL, 1, 1, 1, 2, 2, 2, 1, 1, 2, 2, 1, 16, 'Sangat Baik'),
(11, 24, 1, 1, 2, 2, 2, 1, 1, 1, 2, 1, 2, 16, 'Sangat Baik'),
(12, 4, 1, 2, 2, 1, 1, 1, 1, 1, 2, 2, 2, 16, 'Sangat Baik');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionermager`
--

CREATE TABLE `kuisionermager` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `aktivitasberat` enum('Ya','Tidak') DEFAULT NULL,
  `hariberat` int(11) DEFAULT NULL,
  `jamberat` int(11) DEFAULT NULL,
  `menitberat` int(11) DEFAULT NULL,
  `aktivitassedang` enum('Ya','Tidak') DEFAULT NULL,
  `harisedang` int(11) DEFAULT NULL,
  `jamsedang` int(11) DEFAULT NULL,
  `menitsedang` int(11) DEFAULT NULL,
  `jalansepeda` enum('Ya','Tidak') DEFAULT NULL,
  `hariberjalan` int(11) DEFAULT NULL,
  `jamberjalan` int(11) DEFAULT NULL,
  `menitberjalan` int(11) DEFAULT NULL,
  `olahragaberat` enum('Ya','Tidak') DEFAULT NULL,
  `hariberatolahraga` int(11) DEFAULT NULL,
  `jamberatolahraga` int(11) DEFAULT NULL,
  `menitberatolahraga` int(11) DEFAULT NULL,
  `olahragasedang` enum('Ya','Tidak') DEFAULT NULL,
  `harisedangolahraga` int(11) DEFAULT NULL,
  `jamsedangolahraga` int(11) DEFAULT NULL,
  `menitsedangolahraga` int(11) DEFAULT NULL,
  `waktududuk` int(11) DEFAULT NULL,
  `menitduduk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionermager`
--

INSERT INTO `kuisionermager` (`idkuisioner`, `idusersiswa`, `aktivitasberat`, `hariberat`, `jamberat`, `menitberat`, `aktivitassedang`, `harisedang`, `jamsedang`, `menitsedang`, `jalansepeda`, `hariberjalan`, `jamberjalan`, `menitberjalan`, `olahragaberat`, `hariberatolahraga`, `jamberatolahraga`, `menitberatolahraga`, `olahragasedang`, `harisedangolahraga`, `jamsedangolahraga`, `menitsedangolahraga`, `waktududuk`, `menitduduk`) VALUES
(1, 2, 'Ya', 1, 2, 53, 'Ya', 2, 4, 22, 'Ya', 1, 1, 23, 'Ya', 3, 2, 43, 'Ya', 0, 0, 0, 0, 0),
(2, 2, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Ya', 0, 0, 0, 'Ya', 0, 0, 0, 'Tidak', 0, 0, 0, 0, 0),
(4, 15, 'Ya', 2, 2, 12, 'Tidak', 0, 0, 0, 'Ya', 3, 2, 12, 'Ya', 1, 23, 221, 'Tidak', 0, 0, 0, 0, 0),
(5, 20, 'Ya', 2, 0, 700, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 4, 0),
(6, 22, 'Tidak', 0, 0, 0, 'Ya', 7, 6, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Ya', 3, 0, 30, 7, 0),
(7, 20, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 51, 0),
(8, NULL, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 1, 1),
(9, 8, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Tidak', 0, 0, 0, 'Ya', 2, 1, 2, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `kuisionermakan`
--

CREATE TABLE `kuisionermakan` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `q8` int(11) DEFAULT NULL,
  `q9` int(11) DEFAULT NULL,
  `q10` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionermakan`
--

INSERT INTO `kuisionermakan` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `totalSkor`, `kategori`) VALUES
(1, 15, 0, 1, 1, 1, 0, 2, 1, 1, 2, 2, 11, 'Sedang'),
(2, 17, 0, 1, 0, 1, 1, 0, 2, 2, 1, 2, 10, 'Sedang'),
(3, 4, 1, 2, 2, 1, 1, 1, 2, 2, 1, 2, 15, 'Tinggi'),
(4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Rendah'),
(5, 15, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 18, 'Tinggi'),
(6, 20, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 'Sedang'),
(7, 22, 2, 2, 1, 1, 1, 1, 1, 2, 2, 1, 14, 'Tinggi'),
(8, 4, 2, 2, 2, 2, 2, 0, 0, 0, 0, 0, 10, 'Kurang Sehat'),
(9, 4, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 30, 'Sehat'),
(10, 18, 2, 2, 3, 2, 2, 2, 1, 1, 2, 2, 19, 'Cukup Sehat'),
(11, 20, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 30, 'Sehat'),
(12, NULL, 2, 2, 2, 3, 3, 3, 2, 2, 3, 3, 25, 'Cukup Sehat'),
(13, NULL, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 18, 'Cukup Sehat'),
(14, NULL, 0, 0, 0, 0, 0, 4, 4, 4, 4, 4, 20, 'Cukup Sehat'),
(15, NULL, 0, 0, 0, 0, 0, 4, 4, 4, 4, 4, 20, 'Cukup Sehat'),
(16, 8, 1, 2, 2, 2, 2, 3, 2, 2, 2, 2, 20, 'Cukup Sehat'),
(17, 17, 3, 2, 2, 2, 2, 2, 3, 2, 2, 2, 22, 'Cukup Sehat');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionermenikah`
--

CREATE TABLE `kuisionermenikah` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionermenikah`
--

INSERT INTO `kuisionermenikah` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `totalSkor`, `kategori`) VALUES
(1, 2, 1, 2, 1, 2, 2, 2, 2, 12, 'Ragu-ragu'),
(2, 2, 1, 2, 1, 2, 2, 2, 2, 12, 'Ragu-ragu'),
(3, 2, 0, 0, 1, 1, 1, 1, 2, 6, 'Tidak Siap'),
(4, 2, 1, 2, 2, 0, 0, 2, 1, 8, 'Ragu-ragu'),
(5, 2, 0, 0, 0, 1, 1, 1, 0, 3, 'Tidak Siap'),
(6, 2, 0, 1, 0, 0, 0, 0, 0, 1, 'Tidak Siap'),
(7, 4, 1, 2, 0, 0, 0, 1, 1, 5, 'Tidak Siap'),
(8, 18, 0, 0, 0, 0, 0, 0, 0, 0, 'Tidak Siap'),
(9, 20, 0, 0, 0, 0, 0, 0, 0, 0, 'Tidak Siap'),
(10, 22, 0, 1, 0, 1, 1, 0, 0, 3, 'Tidak Siap'),
(11, 22, 0, 1, 0, 1, 1, 0, 0, 3, 'Tidak Siap'),
(12, NULL, 2, 0, 0, 1, 0, 0, 1, 4, 'Tidak Siap'),
(13, NULL, 0, 1, 1, 1, 1, 1, 2, 7, 'Tidak Siap'),
(14, 17, 0, 1, 1, 1, 0, 0, 1, 4, 'Tidak Siap'),
(15, 24, 0, 0, 1, 1, 0, 0, 0, 2, 'Tidak Siap'),
(16, 8, 1, 0, 1, 1, 1, 0, 1, 5, 'Tidak Siap');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionermental`
--

CREATE TABLE `kuisionermental` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `q8` int(11) DEFAULT NULL,
  `q9` int(11) DEFAULT NULL,
  `q10` int(11) DEFAULT NULL,
  `q11` int(11) DEFAULT NULL,
  `q12` int(11) DEFAULT NULL,
  `q13` int(11) DEFAULT NULL,
  `q14` int(11) DEFAULT NULL,
  `q15` int(11) DEFAULT NULL,
  `totalSkor` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionermental`
--

INSERT INTO `kuisionermental` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`, `q13`, `q14`, `q15`, `totalSkor`, `kategori`) VALUES
(1, 2, 1, 2, 1, 2, 3, 3, 2, 2, 3, 3, 2, 2, 3, 3, 3, 35, 'Sangat Bermasalah'),
(2, 2, 2, 2, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 8, 'Tidak Terdapat Masalah'),
(4, 2, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 'Tidak Terdapat Masalah'),
(5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 30, 'Cukup Bermasalah'),
(6, 2, 1, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 28, 'Cukup Bermasalah'),
(7, 4, 1, 2, 3, 2, 2, 2, 3, 2, 2, 2, 1, 1, 1, 2, 2, 28, 'Cukup Bermasalah'),
(8, 15, 2, 1, 2, 2, 2, 1, 1, 1, 2, 1, 2, 3, 2, 2, 3, 27, 'Cukup Bermasalah'),
(9, 18, 1, 1, 1, 2, 1, 1, 1, 2, 1, 1, 2, 2, 1, 1, 2, 20, 'Cukup Bermasalah'),
(10, 20, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 15, 'Tidak Terdapat Masalah'),
(11, 21, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 5, 'Tidak Terdapat Masalah'),
(12, 22, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 4, 'Tidak Terdapat Masalah'),
(13, 20, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 45, 'Sangat Bermasalah'),
(14, 22, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 3, 'Tidak Terdapat Masalah'),
(15, NULL, 0, 1, 1, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 24, 'Cukup Bermasalah'),
(16, NULL, 1, 1, 2, 2, 2, 1, 2, 2, 3, 3, 2, 2, 2, 2, 2, 29, 'Cukup Bermasalah'),
(17, 17, 1, 1, 1, 2, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 2, 18, 'Cukup Bermasalah'),
(18, 24, 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 10, 'Tidak Terdapat Masalah');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionerperubahanlaki`
--

CREATE TABLE `kuisionerperubahanlaki` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `q8` int(11) DEFAULT NULL,
  `q9` int(11) DEFAULT NULL,
  `q10` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionerperubahanlaki`
--

INSERT INTO `kuisionerperubahanlaki` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `totalSkor`, `kategori`) VALUES
(1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 'Perubahan ringan'),
(2, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 'Perubahan signifikan'),
(3, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 'Perubahan signifikan'),
(4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 'Perubahan ringan'),
(5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 'Perubahan signifikan'),
(6, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Perubahan ringan'),
(8, 18, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 'Perubahan signifikan'),
(9, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 7, 'Perubahan sedang'),
(10, 17, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 'Perubahan signifikan'),
(11, 17, 0, 0, 0, 1, 1, 1, 1, 0, 1, 1, 6, 'Perubahan sedang');

-- --------------------------------------------------------

--
-- Table structure for table `kuisionerperubahanperempuan`
--

CREATE TABLE `kuisionerperubahanperempuan` (
  `idkuisioner` int(11) NOT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `q6` int(11) DEFAULT NULL,
  `q7` int(11) DEFAULT NULL,
  `q8` int(11) DEFAULT NULL,
  `q9` int(11) DEFAULT NULL,
  `totalSkor` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kuisionerperubahanperempuan`
--

INSERT INTO `kuisionerperubahanperempuan` (`idkuisioner`, `idusersiswa`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `totalSkor`, `kategori`) VALUES
(1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 'Perubahan sedang'),
(2, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 'Perubahan sedang'),
(3, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 'Perubahan signifikan'),
(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 'Perubahan sedang'),
(5, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 'Perubahan signifikan'),
(6, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 'Perubahan signifikan'),
(7, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Perubahan ringan'),
(8, 24, 1, 1, 1, 0, 1, 1, 1, 1, 1, 8, 'Perubahan signifikan');

-- --------------------------------------------------------

--
-- Table structure for table `tbsekolah`
--

CREATE TABLE `tbsekolah` (
  `idsekolah` int(11) NOT NULL,
  `namasekolah` varchar(100) NOT NULL,
  `alamatsekolah` varchar(255) NOT NULL,
  `notelpsekolah` varchar(15) DEFAULT NULL,
  `kepalasekolah` varchar(50) NOT NULL,
  `namapjsekolah` varchar(50) NOT NULL,
  `notelpj` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbsekolah`
--

INSERT INTO `tbsekolah` (`idsekolah`, `namasekolah`, `alamatsekolah`, `notelpsekolah`, `kepalasekolah`, `namapjsekolah`, `notelpj`) VALUES
(1, 'SDN 1 LUMBUNG', 'desa lumbung ', '20723123', 'thoriq (haji)', 'amin21', '0821231244'),
(2, 'SMPN 1 LUMBUNG', 'desa patrol', '235214', 'jabrix (metal)', 'solih', '0892342187'),
(4, 'SDN 1 SUKAHURA', 'desa sukahura', '241231299', 'jarox (metal)', 'indung ainx', '0823123412'),
(5, 'SMPN 1 KAWAHU', 'Dusun Kawahu', '02234213124', 'hubner', 'rolih', '08927623748');

-- --------------------------------------------------------

--
-- Table structure for table `tbsiswa`
--

CREATE TABLE `tbsiswa` (
  `idsiswa` int(11) NOT NULL,
  `namalengkapsiswa` varchar(255) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tanggallahir` date DEFAULT NULL,
  `namapanggilan` varchar(100) DEFAULT NULL,
  `jeniskelamin` enum('laki-laki','perempuan') NOT NULL,
  `asalsekolah` int(11) DEFAULT NULL,
  `notelp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbsiswa`
--

INSERT INTO `tbsiswa` (`idsiswa`, `namalengkapsiswa`, `nisn`, `nik`, `tanggallahir`, `namapanggilan`, `jeniskelamin`, `asalsekolah`, `notelp`, `alamat`) VALUES
(1, 'rafian hilmi ramdan', '3200123284285', '32100921413423', '2010-07-21', 'rap, apin, yan, ian', 'laki-laki', 5, '82123412312', 'samtinggg'),
(2, 'faza fauzan', '324291238127', '32009123844124', NULL, 'cil, aca, bocil, pasa', 'laki-laki', 4, '812341235', 'di gigireun tatangga'),
(3, 'gina andriyani', '325723758', '3273847805980', NULL, 'gin, gingin, ina', 'perempuan', 2, '082533525231', 'babantar\r\n'),
(4, 'jojo', '234234', '454545', NULL, 'bleh', 'laki-laki', 4, '08123123192312', 'MESIR MENCARI DIO'),
(8, 'samtingggg', '123123', '31234123412', NULL, 'bleh', 'laki-laki', 2, '0988289323', 'asdfasdfas'),
(9, 'fadhila', '24660123', '3278123344', NULL, 'dil', 'perempuan', 1, '0811111', 'CIBEUREUM'),
(12, 'faris', '11111111111', '19999999', NULL, 'bleh', 'laki-laki', 4, '0999912123', 'neng omah mbah e'),
(13, 'riadho', '22222222222', '24444444423', NULL, 'do', 'laki-laki', 5, '2323123123', 'samping ksotan'),
(14, 'sipa', '3233333323', '222354455', NULL, 'sip', 'perempuan', 4, '123123123123', 'asdfasdfasdfafasdfaf'),
(15, 'cecep', '3232344455', '3123523534', NULL, 'ccp', 'laki-laki', 5, '2312312523523', 'sadfasdfaf'),
(17, 'apinlible', '23323109888717237', '321289987987982132', NULL, 'apoin', 'laki-laki', 5, '823123123764', 'di mana we'),
(18, 'hilmi ramdan', '22312123134412', '112333234412312', '2009-08-24', 'hilmie', 'laki-laki', 1, '8232132321413', 'gigireun imah rapian'),
(19, 'siswaaa', '343123123', '12312423523', NULL, 'ssiwa', 'laki-laki', 5, '8882312312324', 'asdfadsf'),
(20, 'CMYF', '112233', '3206381805030003', NULL, 'CMYF', 'laki-laki', 4, '0', 'didinya'),
(21, 'Arhan Pratama', '123456', '123456', NULL, 'Mas Arhan', 'laki-laki', 1, '87654321', 'Jawa Timur'),
(22, 'Fadhila Azhar', '1234', '1234', NULL, 'Dila', 'perempuan', 2, '8890898999', 'Cibeureum'),
(23, 'KUJO JOLYNE', '22311333', '22312312312', NULL, 'JOJO', 'laki-laki', 5, '1', 'mesir'),
(24, 'ayangggg', '2221133332132', '2331222312312', NULL, 'seng', 'perempuan', 5, '81212312', 'hatiku'),
(25, 'Dinda Adinda', '3321112312312', '22231222222222333331', NULL, 'ndin', 'perempuan', 5, '8923123123123', 'eta di talang'),
(26, 'raidoooo', '332155531238774', '2312355512312513', NULL, 'TUAN MUDA', 'perempuan', 1, '821231234123', 'istana'),
(27, 'something in a way', '22887918273123', '8219309127312', '2002-12-07', 'uhhhhhhhh', 'perempuan', 5, '81226731286', 'mbohlah');

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE `tbuser` (
  `iduser` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` enum('admin','pengurus') NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `asalsekolah` int(11) DEFAULT NULL,
  `status` enum('pending','validated','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`iduser`, `username`, `pass`, `role`, `email`, `asalsekolah`, `status`) VALUES
(1, 'admin', '$2y$10$wzR7USwRArdylY7/hyIuq.781/Bbq7ZX9tLbelnENWkWWdbhFDigO', 'admin', NULL, 5, 'validated'),
(2, 'pengurus1', '$2y$10$0mJ9iunKhv.LVNuiP4Hy4OmbHj9mI1.KfFGG2ouBsIzrCmLCo.ZOq', 'pengurus', 'samting123@gmail.com', 5, 'validated'),
(4, 'pengurus2', '$2y$10$C7wSrui6j.ELpgXXRAZn0O/USk4op.HrjoECyqYCT/4vcaSc7Iisq', 'pengurus', NULL, 2, 'validated'),
(5, 'pengurus3', '$2y$10$AWUQtkY/IMPOtspTAIpnx.xwyQ94YkdcGw7ZQY/8okw9Zi7i2MteW', 'pengurus', NULL, 1, 'validated'),
(6, 'pengurus4', '$2y$10$ASLkz.YurJifxP8QpU/h/.n4o4PwOlho7zRxYcNbbXhWssRGAgcBC', 'pengurus', NULL, 4, 'pending'),
(7, 'pengurus123', '$2y$10$W1Y/rjJHwFgwAOnwmqS9DOq5rRadt/cRNw.9axj/aH/ytFk0VEtxC', 'pengurus', 'pengurus12@gmail.com', 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbusersiswa`
--

CREATE TABLE `tbusersiswa` (
  `idusersiswa` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idsiswa` int(11) DEFAULT NULL,
  `status` enum('pending','validated','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbusersiswa`
--

INSERT INTO `tbusersiswa` (`idusersiswa`, `username`, `pass`, `email`, `idsiswa`, `status`) VALUES
(2, 'rafianaz', '$2y$10$viizzzmSZJVrYr0wqzI0h.LqrzOTIblU4./Uqq9krlZJ9O9dHCcLG', 'ravianhilmiramdan@gmail.com', 1, 'validated'),
(3, 'fazz', '$2y$10$nk/TG1yAV4/SI7JOCQA4hOmg20g7JlfQTcgQRcsDLF1jPnugWLRQu', NULL, 2, 'validated'),
(4, 'gina', '$2y$10$wzjBikplGWOYONWLmQ6aduniYt5.imoJylm59bapK3S5JPiFAK5ge', 'gina@gmail.com', 3, 'validated'),
(5, 'jojogegs', '$2y$10$vmIBbxHiDkx/d74J1pII8OBjPa5pqWEQLVKsHeRr2e5jbXnN/Gi/S', NULL, 4, 'rejected'),
(6, 'fadzz', '$2y$10$b4u4gnSHTYgKNVoHTT5lnO/pBfiP8mWgBgVUVzLuDaCdB.yVCYvB.', NULL, 2, 'validated'),
(8, 'samting', '$2y$10$8Tgost0J/Ni5NbAcqV3Cj.adD/kTc2rogNdCtfVb5qQJl34PuiesS', NULL, 8, 'validated'),
(9, 'fadhila', '$2y$10$RRXHC3dbj9THESuVofpV2O7M82fSIJtzMLCb4uG1bJihs9woIXsfe', NULL, 9, 'validated'),
(11, 'hehehe', '$2y$10$YwuYN97w5i.WBecg/q.tBe1uAQ.TtnymmH.p4hkFYJflb.95wcBTW', NULL, 12, 'validated'),
(12, 'hehehe1', '$2y$10$MCTpqq5oQxuYxeC8KUYjf.0cSvfWzvjTyScF/7zLO7rrcPomC5XJG', NULL, 12, 'pending'),
(13, 'rido', '$2y$10$0AIY2pjwPrdpGGQg/iHHjOdnyEU94TBXCLVjgYD6W5rQLN0iXutN6', NULL, 13, 'pending'),
(14, 'sif', '$2y$10$Q8xGBTeITVpRgs9M/Q.7buHb7RY3O6Da9QJnPgmpAu1e7VLvWDCHu', NULL, 14, 'pending'),
(15, 'C2P', '$2y$10$K5Fs9vA46ImPMJWGoP.BqOF30lEXHrQKFrXJKlv0q2DV.vRF3Fzcm', NULL, 15, 'validated'),
(17, 'apin', '$2y$10$RnyMlr18eEWWw/SNXOzwUO1qviX0QskQaPrR3zPbTHPuh56IgNsze', NULL, 17, 'validated'),
(18, 'hilm', '$2y$10$JsGuzjspWBIZFtGU4FjLNeXomTygU104i5z4OKPoBOEPKxAcXFigq', 'hilm@gmail.com', 18, 'validated'),
(19, 'siswa1', '$2y$10$5Yozo/MnkoSkneqw0AnAzuGn4qJzYD8m..XtsKghO43eN7kj2zcXm', NULL, 19, 'validated'),
(20, 'cecep', '$2y$10$B2feF8.6x6KEjxqurTWKGe6RM8vQ8p97eCNoCAEA0GxhQ0V4M.Sra', NULL, 20, 'validated'),
(21, 'arhanpratama', '$2y$10$5buTBfwvUlp3cpyXgzprpeAb34RB9O89V7bUQQ5En4QsiR3mBAE1G', NULL, 21, 'validated'),
(22, 'fadhilaazh', '$2y$10$1syiOgC4PpZY86Goy.9Ca.p07WJCQBtR8K0JaYRYC05ZrL.C4GcXW', NULL, 22, 'validated'),
(23, 'siswa2', '$2y$10$d5hTLBgZIqwXqV9/OerHBe/bsThD7gDIeY4W45J/GyWyRuGF239yC', NULL, 23, 'validated'),
(24, 'siswa4', '$2y$10$b/Jyc6kjcnnh5mGjhaWqVePtxTycpo0YAco.zWqPFLIDLTdPeLv0a', NULL, 24, 'validated'),
(25, 'dinda', '$2y$10$O.nq/OdFuJHGiM0dLtVS7uNg5BuqsejvHpuVyKj4xX7fQTXMVibU2', NULL, 25, 'validated'),
(26, 'iskandarmuda', '$2y$10$iECAE9IO6.s0q7HJ4hmr5esJB5hpIe2EYYf9Qjvz9dQELT2sBVbze', 'sultaniskandar514@gmail.com', 26, 'validated'),
(27, 'something', '$2y$10$Ymc9IV800kc1vSMwNmMp1u/SjOSynF/ANiF7fnd30sjiAjkWi8gES', 'samtingg@gmail.com', 27, 'validated');

-- --------------------------------------------------------

--
-- Table structure for table `topik`
--

CREATE TABLE `topik` (
  `idtopik` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `isitopik` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `kategori` enum('kesehatan','perubahan','olahraga','mental','pernikahan','kenakalan','lain-lain','lain-lain') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topik`
--

INSERT INTO `topik` (`idtopik`, `iduser`, `idusersiswa`, `isitopik`, `tanggal`, `kategori`) VALUES
(101, NULL, 2, 'samting in a wayyyyyyyy, ummmmmmm', '2024-08-06 07:46:07', 'olahraga'),
(110, NULL, 20, 'gass', '2024-08-22 15:34:03', 'perubahan'),
(111, 1, NULL, 'teset', '2024-08-23 16:34:17', 'kenakalan'),
(150, NULL, 18, 'hehe', '2024-08-28 08:17:34', 'kesehatan'),
(156, 1, NULL, 'AS', '2024-08-28 08:38:01', 'perubahan');

-- --------------------------------------------------------

--
-- Table structure for table `topikperempuan`
--

CREATE TABLE `topikperempuan` (
  `idtopikperempuan` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idusersiswa` int(11) DEFAULT NULL,
  `isitopikperempuan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `kategoriperempuan` enum('kesehatan','perubahan','olahraga','mental','pernikahan','kenakalan','lain-lain') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topikperempuan`
--

INSERT INTO `topikperempuan` (`idtopikperempuan`, `iduser`, `idusersiswa`, `isitopikperempuan`, `tanggal`, `kategoriperempuan`) VALUES
(3, NULL, 2, 'coba-cobi deui we lah hehe', '2024-07-21 23:44:16', 'mental'),
(7, NULL, 3, 'nyobaan deui\nhehehe', '2024-07-22 20:59:11', 'olahraga'),
(18, 1, NULL, 'ea ea ea\nlagu cjr', '2024-08-06 07:42:33', 'mental'),
(21, 1, NULL, 'samtingggg', '2024-08-06 15:55:30', ''),
(22, 1, NULL, 'asldfjasdlf', '2024-08-06 15:59:50', ''),
(23, 1, NULL, 'asdfasdf', '2024-08-06 16:01:00', ''),
(24, 1, NULL, 'samtingggggg in a', '2024-08-06 16:07:14', 'perubahan'),
(25, NULL, 4, 'Test barudak', '2024-08-22 15:28:24', 'olahraga'),
(27, NULL, 4, 'Test barudak', '2024-08-22 16:06:01', 'pernikahan'),
(28, NULL, 4, 'Test barudak', '2024-08-22 16:06:06', 'kesehatan'),
(30, NULL, 4, 'hei ehi', '2024-08-23 17:02:27', 'kesehatan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `imt`
--
ALTER TABLE `imt`
  ADD PRIMARY KEY (`idimt`),
  ADD KEY `imt_ibfk_1` (`idsiswa`);

--
-- Indexes for table `imtperempuan`
--
ALTER TABLE `imtperempuan`
  ADD PRIMARY KEY (`idimtperempuan`),
  ADD KEY `imtperempuan_ibfk_1` (`idsiswa`);

--
-- Indexes for table `kebutuhanenergi`
--
ALTER TABLE `kebutuhanenergi`
  ADD PRIMARY KEY (`idenergi`),
  ADD KEY `fk_kebutuhanenergi_idsiswa` (`idsiswa`),
  ADD KEY `kebutuhanenergi_ibfk_1` (`iduser`);

--
-- Indexes for table `kebutuhanenergiperempuan`
--
ALTER TABLE `kebutuhanenergiperempuan`
  ADD PRIMARY KEY (`idenergiperempuan`),
  ADD KEY `kebutuhanenergiperempuan_ibfk_1` (`iduser`),
  ADD KEY `kebutuhanenergiperempuan_ibfk_2` (`idsiswa`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`idkomen`),
  ADD KEY `komentar_ibfk_1` (`iduser`),
  ADD KEY `komentar_ibfk_2` (`idusersiswa`),
  ADD KEY `komentar_ibfk_3` (`idtopik`);

--
-- Indexes for table `komentarperempuan`
--
ALTER TABLE `komentarperempuan`
  ADD PRIMARY KEY (`idkomenperempuan`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idusersiswa` (`idusersiswa`),
  ADD KEY `idtopikperempuan` (`idtopikperempuan`);

--
-- Indexes for table `kuisionerkesehatanlaki`
--
ALTER TABLE `kuisionerkesehatanlaki`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionerkesehatanperempuan`
--
ALTER TABLE `kuisionerkesehatanperempuan`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionermager`
--
ALTER TABLE `kuisionermager`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `kuisionermager_ibfk_1` (`idusersiswa`);

--
-- Indexes for table `kuisionermakan`
--
ALTER TABLE `kuisionermakan`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionermenikah`
--
ALTER TABLE `kuisionermenikah`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionermental`
--
ALTER TABLE `kuisionermental`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionerperubahanlaki`
--
ALTER TABLE `kuisionerperubahanlaki`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `kuisionerperubahanperempuan`
--
ALTER TABLE `kuisionerperubahanperempuan`
  ADD PRIMARY KEY (`idkuisioner`),
  ADD KEY `idusersiswa` (`idusersiswa`);

--
-- Indexes for table `tbsekolah`
--
ALTER TABLE `tbsekolah`
  ADD PRIMARY KEY (`idsekolah`);

--
-- Indexes for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  ADD PRIMARY KEY (`idsiswa`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `tbsiswa_ibfk_1` (`asalsekolah`);

--
-- Indexes for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `tbuser_ibfk_1` (`asalsekolah`);

--
-- Indexes for table `tbusersiswa`
--
ALTER TABLE `tbusersiswa`
  ADD PRIMARY KEY (`idusersiswa`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_idsiswa` (`idsiswa`);

--
-- Indexes for table `topik`
--
ALTER TABLE `topik`
  ADD PRIMARY KEY (`idtopik`),
  ADD KEY `topik_ibfk_1` (`iduser`),
  ADD KEY `topik_ibfk_2` (`idusersiswa`);

--
-- Indexes for table `topikperempuan`
--
ALTER TABLE `topikperempuan`
  ADD PRIMARY KEY (`idtopikperempuan`),
  ADD KEY `topikperempuan_ibfk_1` (`iduser`),
  ADD KEY `topikperempuan_ibfk_2` (`idusersiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `imt`
--
ALTER TABLE `imt`
  MODIFY `idimt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `imtperempuan`
--
ALTER TABLE `imtperempuan`
  MODIFY `idimtperempuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kebutuhanenergi`
--
ALTER TABLE `kebutuhanenergi`
  MODIFY `idenergi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kebutuhanenergiperempuan`
--
ALTER TABLE `kebutuhanenergiperempuan`
  MODIFY `idenergiperempuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `idkomen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `komentarperempuan`
--
ALTER TABLE `komentarperempuan`
  MODIFY `idkomenperempuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kuisionerkesehatanlaki`
--
ALTER TABLE `kuisionerkesehatanlaki`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kuisionerkesehatanperempuan`
--
ALTER TABLE `kuisionerkesehatanperempuan`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kuisionermager`
--
ALTER TABLE `kuisionermager`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kuisionermakan`
--
ALTER TABLE `kuisionermakan`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kuisionermenikah`
--
ALTER TABLE `kuisionermenikah`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kuisionermental`
--
ALTER TABLE `kuisionermental`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kuisionerperubahanlaki`
--
ALTER TABLE `kuisionerperubahanlaki`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kuisionerperubahanperempuan`
--
ALTER TABLE `kuisionerperubahanperempuan`
  MODIFY `idkuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbsekolah`
--
ALTER TABLE `tbsekolah`
  MODIFY `idsekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  MODIFY `idsiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbusersiswa`
--
ALTER TABLE `tbusersiswa`
  MODIFY `idusersiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `topik`
--
ALTER TABLE `topik`
  MODIFY `idtopik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `topikperempuan`
--
ALTER TABLE `topikperempuan`
  MODIFY `idtopikperempuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `imt`
--
ALTER TABLE `imt`
  ADD CONSTRAINT `imt_ibfk_1` FOREIGN KEY (`idsiswa`) REFERENCES `tbsiswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `imtperempuan`
--
ALTER TABLE `imtperempuan`
  ADD CONSTRAINT `imtperempuan_ibfk_1` FOREIGN KEY (`idsiswa`) REFERENCES `tbsiswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kebutuhanenergi`
--
ALTER TABLE `kebutuhanenergi`
  ADD CONSTRAINT `fk_kebutuhanenergi_idsiswa` FOREIGN KEY (`idsiswa`) REFERENCES `tbsiswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kebutuhanenergi_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kebutuhanenergiperempuan`
--
ALTER TABLE `kebutuhanenergiperempuan`
  ADD CONSTRAINT `kebutuhanenergiperempuan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kebutuhanenergiperempuan_ibfk_2` FOREIGN KEY (`idsiswa`) REFERENCES `tbsiswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_3` FOREIGN KEY (`idtopik`) REFERENCES `topik` (`idtopik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarperempuan`
--
ALTER TABLE `komentarperempuan`
  ADD CONSTRAINT `komentarperempuan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarperempuan_ibfk_2` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarperempuan_ibfk_3` FOREIGN KEY (`idtopikperempuan`) REFERENCES `topikperempuan` (`idtopikperempuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionerkesehatanlaki`
--
ALTER TABLE `kuisionerkesehatanlaki`
  ADD CONSTRAINT `kuisionerkesehatanlaki_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionerkesehatanperempuan`
--
ALTER TABLE `kuisionerkesehatanperempuan`
  ADD CONSTRAINT `kuisionerkesehatanperempuan_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionermager`
--
ALTER TABLE `kuisionermager`
  ADD CONSTRAINT `kuisionermager_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionermakan`
--
ALTER TABLE `kuisionermakan`
  ADD CONSTRAINT `kuisionermakan_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionermenikah`
--
ALTER TABLE `kuisionermenikah`
  ADD CONSTRAINT `kuisionermenikah_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionermental`
--
ALTER TABLE `kuisionermental`
  ADD CONSTRAINT `kuisionermental_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionerperubahanlaki`
--
ALTER TABLE `kuisionerperubahanlaki`
  ADD CONSTRAINT `kuisionerperubahanlaki_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisionerperubahanperempuan`
--
ALTER TABLE `kuisionerperubahanperempuan`
  ADD CONSTRAINT `kuisionerperubahanperempuan_ibfk_1` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  ADD CONSTRAINT `tbsiswa_ibfk_1` FOREIGN KEY (`asalsekolah`) REFERENCES `tbsekolah` (`idsekolah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD CONSTRAINT `tbuser_ibfk_1` FOREIGN KEY (`asalsekolah`) REFERENCES `tbsekolah` (`idsekolah`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbusersiswa`
--
ALTER TABLE `tbusersiswa`
  ADD CONSTRAINT `fk_idsiswa` FOREIGN KEY (`idsiswa`) REFERENCES `tbsiswa` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topik`
--
ALTER TABLE `topik`
  ADD CONSTRAINT `topik_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topik_ibfk_2` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topikperempuan`
--
ALTER TABLE `topikperempuan`
  ADD CONSTRAINT `topikperempuan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tbuser` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topikperempuan_ibfk_2` FOREIGN KEY (`idusersiswa`) REFERENCES `tbusersiswa` (`idusersiswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
