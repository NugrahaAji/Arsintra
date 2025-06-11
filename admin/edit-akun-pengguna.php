<?php
session_start();
require_once '../config.php';
$error = '';
$success = '';
if (!isset($_SESSION['admin_id'])) {
    header('Location: adminlogin.php');
    exit();
}
if (!isset($_GET['id'])) {
    header('Location: admindashboard.php');
    exit();
}
$id = intval($_GET['id']);
// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    header('Location: admindashboard.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    if ($nama && $username && $email && $kategori) {
        $stmt2 = $conn->prepare("UPDATE users SET username=?, nama=?, email=?, kategori=? WHERE id=?");
        $stmt2->bind_param('ssssi', $username, $nama, $email, $kategori, $id);
        if ($stmt2->execute()) {
            $success = 'Akun berhasil diupdate!';
        } else {
            $error = 'Gagal update akun. Email mungkin sudah terdaftar.';
        }
        $stmt2->close();
    } else {
        $error = 'Semua field wajib diisi!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun - Arsintra</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Arsintra</h1>
        </div>
        <nav class="sidebar-nav">
            <a href="admindashboard.php" class="sidebar-item active">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Beranda</span>
            </a>
            <a href="adminlogout.php" class="sidebar-item">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Keluar</span>
            </a>
        </nav>
    </div>
    <div class="main-content">
        <main class="page-content">
            <div class="page-header">
                <h1>Edit Akun</h1>
                <div class="header-actions">
                    <a href="admindashboard.php" class="btn-back">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M19 12H5m7-7l-7 7 7 7"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
            <?php if ($success): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
                <a href="admindashboard.php">Kembali ke daftar akun</a>
            </div>
            <?php endif; ?>
            <?php if ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            <div class="form-container-page">
                <form class="form-grid" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama<span class="required">*</span></label>
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username<span class="required">*</span></label>
                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email<span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori<span class="required">*</span></label>
                            <select id="kategori" name="kategori" class="custom-select" required>
                                <option value="User" <?= $user['kategori'] === 'User' ? 'selected' : '' ?>>User</option>
                                <option value="Admin" <?= $user['kategori'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<div id="logoutModal" class="modal-overlay hidden">
  <div class="modal-content">
    <h3 class="modal-confirm">Yakin ingin keluar?</h3>
    <p>Anda akan keluar dari sistem.</p>
    <div class="modal-actions">
      <button id="cancelLogout" class="btn-cancel">Batal</button>
      <a href="adminlogout.php" class="btn-logout">Keluar</a>
    </div>
  </div>
</div>
<script>
  const logoutBtn = document.querySelector('.sidebar-item[href="adminlogout.php"]');
  const modal = document.getElementById('logoutModal');
  const cancelBtn = document.getElementById('cancelLogout');

  logoutBtn.addEventListener('click', function (e) {
    e.preventDefault();
    modal.classList.remove('hidden');
  });

  cancelBtn.addEventListener('click', function () {
    modal.classList.add('hidden');
  });

  window.addEventListener('click', function (e) {
    if (e.target === modal) {
      modal.classList.add('hidden');
    }
  });
</script>
</body>
</html>
