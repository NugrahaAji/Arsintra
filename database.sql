-- 1. Buat database
CREATE DATABASE IF NOT EXISTS arsintra_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE arsintra_db;

-- 2. Buat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    kategori ENUM('Admin','User') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- 3. Insert admin default (password: admin123)
INSERT INTO users (username, nama, kategori, email, password) VALUES
(
    'admin',
    'Administrator',
    'Admin',
    'admin@arsintra.com',
    '$2y$10$wH8Qw6Qw6Qw6Qw6Qw6Qw6eQw6Qw6Qw6Qw6Qw6Qw6Qw6Qw6Qw6Qw6'
);
-- Password di atas adalah hash bcrypt dummy, nanti bisa diganti lewat aplikasi. 

-- Table for archive staff (petugas arsip)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for incoming letters (surat masuk)
CREATE TABLE surat_masuk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) NOT NULL,
    tanggal_surat DATE NOT NULL,
    tanggal_terima DATE NOT NULL,
    pengirim VARCHAR(100) NOT NULL,
    perihal TEXT NOT NULL,
    file_path VARCHAR(255),
    status ENUM('belum_diproses', 'diproses', 'selesai') DEFAULT 'belum_diproses',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Table for outgoing letters (surat keluar)
CREATE TABLE surat_keluar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) NOT NULL,
    tanggal_surat DATE NOT NULL,
    tujuan VARCHAR(100) NOT NULL,
    perihal TEXT NOT NULL,
    file_path VARCHAR(255),
    status ENUM('draft', 'terkirim') DEFAULT 'draft',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Table for letter dispositions (disposisi)
CREATE TABLE disposisi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    surat_masuk_id INT NOT NULL,
    nomor_disposisi VARCHAR(50) NOT NULL,
    tanggal_disposisi DATE NOT NULL,
    ditujukan_kepada VARCHAR(100) NOT NULL,
    isi_disposisi TEXT NOT NULL,
    status ENUM('belum_diproses', 'diproses', 'selesai') DEFAULT 'belum_diproses',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (surat_masuk_id) REFERENCES surat_masuk(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
); 