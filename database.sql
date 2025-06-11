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