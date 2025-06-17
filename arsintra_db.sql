-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 17 Jun 2025 pada 11.19
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

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
-- Struktur dari tabel `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int NOT NULL,
  `surat_masuk_id` int NOT NULL,
  `nomor_disposisi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_disposisi` date NOT NULL,
  `ditujukan_kepada` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_disposisi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('belum_diproses','diproses','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'belum_diproses',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int NOT NULL,
  `nomor_surat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `di_keluarkan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_surat` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','terkirim') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `nomor_surat`, `nama_surat`, `kategori`, `tanggal_keluar`, `di_keluarkan`, `tujuan_surat`, `deskripsi_surat`, `file_path`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(4, '002', 'Proposal Kegiatan Pelatihan Matawq', 'Proposal', '2025-06-11', 'Ketua Himakorn', 'Himakorn FMIPA UNILA', 'adadadada', 'uploads/surat_keluar/1749618631_Screenshot 2025-06-10 102307.png', 'draft', 5, '2025-06-11 05:10:31', '2025-06-17 11:13:34'),
(5, '001', 'Proposal Oprec', 'Proposal', '2025-06-11', 'Ketua Himakorn', 'Himakorn FMIPA UNILA', 'jvvhvkh', 'uploads/surat_keluar/1749619837_Screenshot 2025-06-04 120502.png', 'draft', 5, '2025-06-11 05:30:37', '2025-06-17 11:13:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int NOT NULL,
  `nomor_surat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `petugas_arsip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_lampiran` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_surat` text COLLATE utf8mb4_unicode_ci,
  `tanggal_surat` date NOT NULL,
  `tanggal_terima` date NOT NULL,
  `pengirim` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perihal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('selesai','menunggu','ditolak') COLLATE utf8mb4_unicode_ci DEFAULT 'menunggu',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `nomor_surat`, `asal_surat`, `nama_surat`, `kategori`, `tanggal_masuk`, `petugas_arsip`, `jumlah_lampiran`, `deskripsi_surat`, `tanggal_surat`, `tanggal_terima`, `pengirim`, `perihal`, `file_path`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(5, '001', 'Himakorn FMIPA UNILA', 'Proposal Kegiatan Pelatihan anu', 'Proposalalalal', '2025-06-11', 'Dea Delvinata', '3', 'jeeleekkk', '0000-00-00', '0000-00-00', '', '', 'uploads/surat_masuk/684913ab732a7_Screenshot 2025-06-10 083415.png', 'ditolak', 5, '2025-06-11 05:27:07', '2025-06-17 11:16:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `created_at`, `updated_at`) VALUES
(3, 'adminin', '$2y$10$OQi3xVzcQ7vdza8dXRl2xOSNLnmnUWzTgR1oXyd9akwDGBzZY1Wy2', 'admin', 'admin@admin.com', 'admin', '2025-06-16 15:03:11', '2025-06-17 11:15:30'),
(4, 'alif', '$2y$10$sCLecXfP5WDlw2GLI5U51ualqG3RHqUrYCsSqU3DNtxEVOYbZxgHG', 'Muhammad Alif Abrararar', 'abraralif3@gmail.com', 'petugas', '2025-06-16 15:04:36', '2025-06-17 11:14:08'),
(5, 'pengguna', '$2y$10$lit5Pgcpud6Z3IRP6Kk2ceKrm2Pdt336t08mssyvi5/O1t5yDcQt6', 'Pengguna Arsintra', 'pengguna@arsintra.com', 'petugas', '2025-06-17 11:09:37', '2025-06-17 11:09:37'),
(6, 'dea', '$2y$10$TQB7SdM2PlUFTiMylQJ3qeDS/HibdXhfln/P4BOd4BeIqsTuqCixC', 'Dea Delvi', 'dea@arsintra.com', 'petugas', '2025-06-17 11:14:37', '2025-06-17 11:14:37');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `trg_sebelum_hapus_user` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
    DECLARE id_admin_baru INT;
    SET id_admin_baru = 5;

    UPDATE surat_keluar SET created_by = id_admin_baru 	WHERE created_by = OLD.id;

    UPDATE surat_masuk SET created_by = id_admin_baru WHERE created_by = OLD.id;

    UPDATE disposisi SET created_by = id_admin_baru WHERE created_by = OLD.id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_masuk_id` (`surat_masuk_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_ibfk_1` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuk` (`id`),
  ADD CONSTRAINT `disposisi_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `surat_keluar_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `surat_masuk_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
