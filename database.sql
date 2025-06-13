-- 1. Buat database
CREATE DATABASE IF NOT EXISTS arsintra_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE arsintra_db;

-- 2. Buat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    kategori ENUM('Admin','User') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Insert admin default (password: admin123)
INSERT INTO users (username, nama_lengkap, kategori, email, password) VALUES
(
    'admin',
    'Administrator',
    'Admin',
    'admin@arsintra.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);

-- Table for incoming letters (surat masuk)
CREATE TABLE surat_masuk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) NOT NULL,
    asal_surat VARCHAR(100) NOT NULL,
    nama_surat VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    petugas_arsip VARCHAR(100) NOT NULL,
    jumlah_lampiran INT NOT NULL,
    file_path VARCHAR(255),
    deskripsi_surat TEXT NOT NULL,
    status ENUM('menunggu', 'selesai', 'ditolak') DEFAULT 'menunggu',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Table for outgoing letters (surat keluar)
CREATE TABLE surat_keluar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nomor_surat VARCHAR(50) NOT NULL,
    nama_surat VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tanggal_keluar DATE NOT NULL,
    di_keluarkan VARCHAR(100) NOT NULL,
    tujuan_surat VARCHAR(100) NOT NULL,
    deskripsi_surat TEXT NOT NULL,
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