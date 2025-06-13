<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$type = $_GET['type'];

if (!in_array($type, ['masuk', 'keluar'])) {
    header('Location: dashboard.php');
    exit();
}

$table = $type === 'masuk' ? 'surat_masuk' : 'surat_keluar';
$query = "SELECT file_path, nama_surat FROM $table WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: dashboard.php');
    exit();
}

$row = $result->fetch_assoc();
$file_path = $row['file_path'];
$file_name = $row['nama_surat'];

if (!file_exists("../$file_path")) {
    header('Location: dashboard.php');
    exit();
}

$extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

switch ($extension) {
    case 'pdf':
        header('Content-Type: application/pdf');
        break;
    case 'jpg':
    case 'jpeg':
        header('Content-Type: image/jpeg');
        break;
    case 'png':
        header('Content-Type: image/png');
        break;
    case 'doc':
        header('Content-Type: application/msword');
        break;
    case 'docx':
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        break;
    default:
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '.' . $extension . '"');
        break;
}

readfile("../$file_path");
exit(); 