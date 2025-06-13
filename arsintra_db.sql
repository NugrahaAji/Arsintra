-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 06:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsintra_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int(11) NOT NULL,
  `surat_masuk_id` int(11) NOT NULL,
  `nomor_disposisi` varchar(50) NOT NULL,
  `tanggal_disposisi` date NOT NULL,
  `ditujukan_kepada` varchar(100) NOT NULL,
  `isi_disposisi` text NOT NULL,
  `status` enum('belum_diproses','diproses','selesai') DEFAULT 'belum_diproses',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(50) NOT NULL,
  `nama_surat` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `di_keluarkan` varchar(100) NOT NULL,
  `tujuan_surat` varchar(100) NOT NULL,
  `deskripsi_surat` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','terkirim') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `nomor_surat`, `nama_surat`, `kategori`, `tanggal_keluar`, `di_keluarkan`, `tujuan_surat`, `deskripsi_surat`, `file_path`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(4, '002', 'Proposal Kegiatan Pelatihan Matawq', 'Proposal', '2025-06-11', 'Ketua Himakorn', 'Himakorn FMIPA UNILA', 'adadadada', 'uploads/surat_keluar/1749618631_Screenshot 2025-06-10 102307.png', 'draft', 1, '2025-06-11 05:10:31', '2025-06-11 05:10:52'),
(5, '001', 'Proposal Oprec', 'Proposal', '2025-06-11', 'Ketua Himakorn', 'Himakorn FMIPA UNILA', 'jvvhvkh', 'uploads/surat_keluar/1749619837_Screenshot 2025-06-04 120502.png', 'draft', 1, '2025-06-11 05:30:37', '2025-06-11 05:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(100) DEFAULT NULL,
  `nama_surat` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `petugas_arsip` varchar(100) DEFAULT NULL,
  `jumlah_lampiran` varchar(50) DEFAULT NULL,
  `deskripsi_surat` text DEFAULT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_terima` date NOT NULL,
  `pengirim` varchar(100) NOT NULL,
  `perihal` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('selesai','menunggu','ditolak') DEFAULT 'menunggu',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `nomor_surat`, `asal_surat`, `nama_surat`, `kategori`, `tanggal_masuk`, `petugas_arsip`, `jumlah_lampiran`, `deskripsi_surat`, `tanggal_surat`, `tanggal_terima`, `pengirim`, `perihal`, `file_path`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(5, '001', 'Himakorn FMIPA UNILA', 'Proposal Kegiatan Pelatihan anu', 'Proposal', '2025-06-11', 'Dea Delvinata', '3', 'dada', '0000-00-00', '0000-00-00', '', '', 'uploads/surat_masuk/684913ab732a7_Screenshot 2025-06-10 083415.png', 'menunggu', 1, '2025-06-11 05:27:07', '2025-06-12 06:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','petugas') NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'dea', '$2y$10$zBrhTSxphW5Z2txdZnuRiu4B5j61paalEiK6v1bFXNuC7VuZKWvEi', 'Dea Delvinata Riyan', 'dea@gmail.com', 'petugas', '2025-06-11 01:18:23', '2025-06-11 01:18:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_masuk_id` (`surat_masuk_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_ibfk_1` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id`),
  ADD CONSTRAINT `disposisi_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
