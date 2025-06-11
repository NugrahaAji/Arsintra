<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

if (!isset($_GET['id'])) {
    header('Location: surat-keluar.php?error=ID surat tidak valid');
    exit();
}

$id = $_GET['id'];

try {
    // Get file path before deleting
    $stmt = $conn->prepare("SELECT file_path FROM surat_keluar WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        header('Location: surat-keluar.php?error=Surat tidak ditemukan');
        exit();
    }

    $row = $result->fetch_assoc();
    $file_path = $row['file_path'];

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM surat_keluar WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if (!$stmt->execute()) {
        throw new Exception("Gagal menghapus surat dari database");
    }

    // Delete file if exists
    if (!empty($file_path) && file_exists("../$file_path")) {
        unlink("../$file_path");
    }

    header('Location: surat-keluar.php?success=2');
    exit();
} catch (Exception $e) {
    error_log("Error in hapus-surat-keluar.php: " . $e->getMessage());
    header('Location: surat-keluar.php?error=' . urlencode($e->getMessage()));
    exit();
} 