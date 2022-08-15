-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2022 at 05:04 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id_absensi` int(11) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `maksimal_kerja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id_absensi`, `jam_masuk`, `jam_pulang`, `maksimal_kerja`) VALUES
(1, '08:30:00', '15:30:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'admin'),
(7, 'Manager'),
(8, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `kode_id` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`id_karyawan`, `kode_id`, `nama`, `id_jabatan`, `password`) VALUES
(1, 'A218', 'admin123', 1, '$2y$10$10DjCUGm5nyul3UfsSEivOqbi7WghBcJkoz8jeA07GXeIJKJND0iO'),
(3, 'M22081', 'Nurhadi Sasono', 7, '$2y$10$GESdLo9wvt4m4eV5EQhdxekmAJ6p7kmD.Ro0MjpwFWeT6gvvKZSIK'),
(4, 'S22083', 'Jesti', 8, '$2y$10$U1ohFCVV/tr6Ik7RoYqDxeSC5jBKQPCS4KlLz.Dsp00QvuWsjyqbu'),
(5, 'S22084', 'Rico Malangi', 8, '$2y$10$TAkhrAdHxVB2H50gI76ASOZr2NhJS/aLeRdg3ILAXiCRxHrtN2g1C'),
(6, 'S22085', 'Farhan Azami', 8, '$2y$10$7lel4nDhqotvcXmJC25NE.HY2n792w.F/8qPE8CSe02f76FK1dGWa');

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi`
--

CREATE TABLE `tb_presensi` (
  `id_presensi` int(11) NOT NULL,
  `kode_id_karyawan` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk_kantor` time NOT NULL,
  `jam_pulang_kantor` time NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `status_kehadiran` varchar(30) NOT NULL,
  `status_kerja` varchar(30) NOT NULL,
  `status_absensi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_presensi`
--

INSERT INTO `tb_presensi` (`id_presensi`, `kode_id_karyawan`, `tanggal`, `jam_masuk_kantor`, `jam_pulang_kantor`, `jam_masuk`, `jam_keluar`, `status_kehadiran`, `status_kerja`, `status_absensi`) VALUES
(1, 'M22081', '2022-08-14', '09:00:00', '18:00:00', '15:54:15', '15:54:35', 'terlambat 6 jam 54 menit', 'kerja < 9 jam', 2),
(2, 'S22083', '2022-08-14', '08:30:00', '15:30:00', '15:56:57', '15:57:49', 'terlambat 7 jam 26 menit', 'kerja < 7 jam', 2),
(3, 'S22083', '2022-08-15', '08:30:00', '15:30:00', '10:05:39', '10:05:47', 'terlambat 1 jam 35 menit', 'kerja < 7 jam', 2),
(4, 'M22081', '2022-08-01', '08:30:00', '15:30:00', '08:57:00', '18:57:00', 'terlambat 0 jam 27 menit', 'lembur 3 jam', 2),
(5, 'M22081', '2022-08-02', '08:30:00', '15:30:00', '08:30:00', '20:58:00', 'tepat waktu', 'lembur 5 jam', 2),
(6, 'S22085', '2022-08-15', '08:30:00', '15:30:00', '12:14:48', '12:14:50', 'terlambat 3 jam 44 menit', 'kerja < 7 jam', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_status_absensi`
--

CREATE TABLE `tb_status_absensi` (
  `id_status` int(11) NOT NULL,
  `nama_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_status_absensi`
--

INSERT INTO `tb_status_absensi` (`id_status`, `nama_status`) VALUES
(1, 'Masuk'),
(2, 'Pulang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `status_absensi` (`status_absensi`);

--
-- Indexes for table `tb_status_absensi`
--
ALTER TABLE `tb_status_absensi`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_status_absensi`
--
ALTER TABLE `tb_status_absensi`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD CONSTRAINT `tb_karyawan_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `tb_jabatan` (`id_jabatan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD CONSTRAINT `tb_presensi_ibfk_2` FOREIGN KEY (`status_absensi`) REFERENCES `tb_status_absensi` (`id_status`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
