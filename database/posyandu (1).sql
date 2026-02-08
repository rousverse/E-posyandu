-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 09:01 AM
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
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Table structure for table `anak`
--

CREATE TABLE `anak` (
  `id_anak` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `umur` varchar(5) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `nma_orgtua` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anak`
--

INSERT INTO `anak` (`id_anak`, `nama`, `jk`, `umur`, `tgl_lahir`, `nma_orgtua`, `alamat`) VALUES
(1, 'Bima', 'Laki-laki', '3', '2024-06-05', 'dani', 'tengayun'),
(3, 'nopek', 'Perempuan', '5', '2024-06-05', 'dani', 'dfygu'),
(5, 'Safi', 'Laki-laki', '2', '2023-03-15', 'Rani', 'jl. mawar'),
(6, 'Syaza Rous Cania', 'Perempuan', '4', '2021-11-18', 'Rani', 'Jl. nangka');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `lokasi` varchar(500) NOT NULL,
  `keterangan` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `tanggal`, `waktu`, `lokasi`, `keterangan`) VALUES
(1, '2025-06-04', '08.00-10.00', 'Posyandu Syaza', 'Imunisasi dan suntik vaksin');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id_pemeriksaan` int(11) NOT NULL,
  `nama_anak` varchar(500) NOT NULL,
  `umur` varchar(200) NOT NULL,
  `tinggi` varchar(500) NOT NULL,
  `berat` varchar(1000) NOT NULL,
  `jeniskelamin` varchar(10) NOT NULL,
  `imunisasi` varchar(500) NOT NULL,
  `vitamin` varchar(500) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `waktu` time NOT NULL,
  `catatan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`id_pemeriksaan`, `nama_anak`, `umur`, `tinggi`, `berat`, `jeniskelamin`, `imunisasi`, `vitamin`, `tanggal`, `waktu`, `catatan`) VALUES
(17, 'Safi', '2', '123', '11', 'Laki-laki', 'Hepatitis', 'Vitamin C', '2025-06-30', '05:46:00', 'Sehat');

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE `tbuser` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`id`, `username`, `password`) VALUES
(15, 'syaza', '12345'),
(16, 'syaza', '$2y$10$q.xVwBGSVwfMhbk7UJsCEeQ69ET6M76DOxJOJPXtJTlM54Lq'),
(17, 'nia', '$2y$10$1xfA1rOa2orxVLGUBow0euS.4HmkQaxrat9qGMXu7vdftGYF'),
(18, 'jane', '$2y$10$OU5jNdOYfogQKdlIy3W9I.fdpGl0eVSWju.jZx1IRX9A8WNY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anak`
--
ALTER TABLE `anak`
  ADD PRIMARY KEY (`id_anak`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`);

--
-- Indexes for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anak`
--
ALTER TABLE `anak`
  MODIFY `id_anak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
