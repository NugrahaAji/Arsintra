<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

// Validasi input awal
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    // Lebih baik redirect kembali ke halaman sebelumnya dengan pesan error
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php') . '?error=parameter_hilang');
    exit();
}

$id = (int)$_GET['id']; // Pastikan ID adalah integer
$type = $_GET['type'];

if (!in_array($type, ['masuk', 'keluar'])) {
    header('Location: dashboard.php?error=tipe_salah');
    exit();
}

// Ambil data file dari database
$table = $type === 'masuk' ? 'surat_masuk' : 'surat_keluar';
$query = "SELECT file_path, nama_surat FROM $table WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: dashboard.php?error=data_tidak_ditemukan');
    exit();
}

// Ambil path dan nama surat dari database
$row = $result->fetch_assoc();
$file_path_from_db = $row['file_path'];
$nama_surat = $row['nama_surat'];

// Pastikan path file tidak kosong
if (empty($file_path_from_db)) {
    die('Error: Path file tidak tercatat di database.');
}

// Buat path file yang benar di server
$full_server_path = "../" . $file_path_from_db;

if (!file_exists($full_server_path)) {
    die('Error: File tidak dapat ditemukan di server.');
}

// --- BAGIAN YANG DIPERBAIKI LAGI UNTUK LEBIH AMAN ---

// 1. Siapkan nama file dasar yang bersih dari nama_surat
$safe_filename_base = '';
if (!empty($nama_surat)) {
    // Bersihkan nama surat dari karakter ilegal
    $safe_filename_base = preg_replace('/[\\\\/:*?"<>|]/', '', $nama_surat);
}

// 2. Logika Fallback:
//    Jika nama surat kosong ATAU setelah dibersihkan jadi kosong,
//    gunakan nama file asli dari path sebagai gantinya.
if (empty($safe_filename_base)) {
    $final_download_name = basename($file_path_from_db);
} else {
    // Jika nama surat valid, gabungkan dengan ekstensinya
    $extension = pathinfo($file_path_from_db, PATHINFO_EXTENSION);
    $final_download_name = $safe_filename_base . '.' . $extension;
}


// --- Kirim Header untuk Download ---
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $final_download_name . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($full_server_path));

// Peningkatan kecil: bersihkan output buffer sebelum mengirim file
ob_clean();
flush();

// Kirim file ke browser
readfile($full_server_path);
exit();
?>