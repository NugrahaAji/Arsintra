<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlogin.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: admindashboard.php');
    exit();
}

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: admindashboard.php');
    exit();
}

if ($id === $_SESSION['admin_id']) {
    $_SESSION['error'] = 'Tidak dapat menghapus akun yang sedang digunakan!';
    header('Location: admindashboard.php');
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Akun berhasil dihapus!';
} else {
    $_SESSION['error'] = 'Gagal menghapus akun!';
}

$stmt->close();
header('Location: admindashboard.php');
exit(); 