<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;

// Get surat data first to get file path
$stmt = $conn->prepare("SELECT file_path FROM surat_masuk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();

if ($surat) {
    // Delete file if exists
    if ($surat['file_path'] && file_exists('../' . $surat['file_path'])) {
        unlink('../' . $surat['file_path']);
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM surat_masuk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: surat-masuk.php');
exit(); 