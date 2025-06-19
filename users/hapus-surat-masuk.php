<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT file_path FROM surat_masuk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();
$file_path = $surat['file_path'];

if ($surat) {
    if ($surat['file_path'] && file_exists('../$file_path')) {
        unlink("../$file_path");
    }

    $stmt = $conn->prepare("DELETE FROM surat_masuk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: surat-masuk.php');
exit();
