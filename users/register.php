<?php
require_once '../config.php';
require_once '../config/session.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password) || empty($nama_lengkap) || empty($email)) {
        $error = "Semua field harus diisi";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok";
    } else {

        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            $error = "Username atau email sudah terdaftar";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, nama_lengkap, email, role) VALUES (?, ?, ?, ?, 'petugas')");
            $stmt->bind_param("ssss", $username, $hashed_password, $nama_lengkap, $email);

            try {
                if ($stmt->execute()) {
                    $success = "Registrasi berhasil! Silakan login.";
                } else {
                    $error = "Terjadi kesalahan saat mendaftar";
                }
            } catch (Exception $e) {
                $error = "Terjadi kesalahan saat mendaftar";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arsintra - Daftar</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <nav class="navbar">
    <div class="navbar-inner">
      <h1 class="navbar-brand">Arsintra</h1>
    </div>
  </nav>
  <section class="full-screen-section">
    <div class="background-image">
      <img src="../asset/image/login-bg.png" alt="Login Background" style="width: 100%; height: 100%; object-fit: cover;" />
    </div>

    <div class="form-container" style="margin-top: 30px; min-height: 100vh; overflow-y: auto;">
      <div class="form-inner" style="padding: 50px 0;">
        <div>
          <h1 class="heading-bold">Buat Akunmu!</h1>
        </div>

        <?php if ($error): ?>
        <div class="error-message" style="margin-top: 50px;">
          <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="success-message">
          <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>

        <form class="form" method="POST">
          <div class="form-group">
            <label for="username">Username<span class="required">*</span></label><br />
            <input type="text" placeholder="Masukkan Username" name="username" required />
          </div>

          <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap<span class="required">*</span></label><br />
            <input type="text" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required />
          </div>

          <div class="form-group">
            <label for="email">Email<span class="required">*</span></label><br />
            <input type="email" placeholder="Masukkan Email" name="email" required />
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="password" required />
          </div>

          <div class="form-group">
            <label for="confirm_password">Konfirmasi Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="confirm_password" required />
          </div>

          <div class="button-group">
            <button type="submit" class="btn btn-primary">Selanjutnya</button>
            <a href="login.php" class="btn btn-secondary">Sudah Punya Akun</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
