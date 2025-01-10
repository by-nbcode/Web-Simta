-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2024 at 09:19 AM
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
-- Database: `db_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_proyek`
--

CREATE TABLE `monitoring_proyek` (
  `id_monitoring` int(11) NOT NULL,
  `id_mhs` int(11) DEFAULT NULL,
  `sk_akademik` varchar(255) DEFAULT NULL,
  `sk_keuangan` varchar(255) DEFAULT NULL,
  `laporan` varchar(255) DEFAULT NULL,
  `ppt` varchar(255) DEFAULT NULL,
  `proyek` enum('Berjalan','Error') DEFAULT NULL,
  `git_link` varchar(255) DEFAULT NULL,
  `progres` int(11) DEFAULT 0,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id_dosen` int(10) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_dosen` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `id_user`) VALUES
(6, '2001020998876', 'Dosen Pembimning', 'ikbal@gmail.com', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal_bimbingan`
--

CREATE TABLE `tb_jadwal_bimbingan` (
  `id_jb` bigint(20) UNSIGNED NOT NULL,
  `id_mhs` bigint(20) NOT NULL,
  `id_dosen` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `status_jb` enum('Diterima','Ditolak','Menunggu Konfirmasi Dosen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id_mhs` int(10) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `nama_mhs` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL,
  `agama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id_mhs`, `nim`, `nama_mhs`, `prodi`, `angkatan`, `jenis_kelamin`, `status`, `agama`, `email`, `id_user`) VALUES
(19, '200102059', 'SUGIAT NURLETE', 'Sistem Informasi', '2020', 'Laki-Laki', 'Aktif', 'Islam', 'sugiat@gmail.com', 26),
(20, '200102039', 'ADE TIA RUMBIA', 'Sistem Informasi', '2020', 'Perempuan', 'Aktif', 'Islam', 'adetia@gmail.com', 27);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ta`
--

CREATE TABLE `tb_ta` (
  `id_ta` bigint(20) UNSIGNED NOT NULL,
  `id_mhs` int(11) NOT NULL,
  `judul_ta` text NOT NULL,
  `tanggal_pegajuan` date NOT NULL,
  `tim` enum('Kelompok','Individu') NOT NULL,
  `status_ta` enum('Menunggu Persetujuan','Disetujui','Ditolak','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_ta`
--

INSERT INTO `tb_ta` (`id_ta`, `id_mhs`, `judul_ta`, `tanggal_pegajuan`, `tim`, `status_ta`) VALUES
(53, 19, 'Sistem Informasi Akademik', '2024-10-19', 'Kelompok', 'Disetujui'),
(54, 20, 'Sistem Informasi Akadmik ( Kel : SUGIAT NURLETE )', '2024-10-19', 'Kelompok', 'Disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Dosen','Mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'Admin', '$2y$10$9E2HdHdc7LBmDjpIpl/eQ.2aBp2zIksHtWAH/DI7EkzDJZ/jOeqqi', 'Admin'),
(15, 'Ikbal', '$2y$10$spFLvQrx4m7zTN0jcE4uVeW.FJfHGt0KRaHLKsvPrhVgF1pjnYpXK', 'Dosen'),
(26, 'Sugiat', '$2y$10$3RMd7euyAyv5O7jO6b65LOsW1LtTTm9k/JA7qAqdHerOBL8Z.Vf0e', 'Mahasiswa'),
(27, 'Ade Tia', '$2y$10$.p0z4NHap9KGp5mDlmjUO.T/tX/u33BGZ.pP8le7UTUAZENZnOTT2', 'Mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `monitoring_proyek`
--
ALTER TABLE `monitoring_proyek`
  ADD PRIMARY KEY (`id_monitoring`);

--
-- Indexes for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `tb_jadwal_bimbingan`
--
ALTER TABLE `tb_jadwal_bimbingan`
  ADD PRIMARY KEY (`id_jb`);

--
-- Indexes for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id_mhs`);

--
-- Indexes for table `tb_ta`
--
ALTER TABLE `tb_ta`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `monitoring_proyek`
--
ALTER TABLE `monitoring_proyek`
  MODIFY `id_monitoring` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  MODIFY `id_dosen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_jadwal_bimbingan`
--
ALTER TABLE `tb_jadwal_bimbingan`
  MODIFY `id_jb` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id_mhs` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_ta`
--
ALTER TABLE `tb_ta`
  MODIFY `id_ta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
