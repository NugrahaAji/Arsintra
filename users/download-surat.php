<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;

// Get surat data
$stmt = $conn->prepare("SELECT file_path, nama_surat FROM surat_masuk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();

if (!$surat || !$surat['file_path']) {
    header('Location: surat-masuk.php');
    exit();
}

$file_path = '../' . $surat['file_path'];
$file_name = basename($surat['file_path']);

if (file_exists($file_path)) {
    // Get file extension
    $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    
    // Set appropriate headers
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $surat['nama_surat'] . '.' . $ext . '"');
    header('Content-Length: ' . filesize($file_path));
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Output file
    readfile($file_path);
    exit();
} else {
    header('Location: surat-masuk.php');
    exit();
} 