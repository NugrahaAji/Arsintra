<?php
session_start();
require_once '../config.php';
require_once '../config/session.php';

if (isLoggedIn()) {
    header("Location: admindashboard.php");
    exit();
}
$error = '';
$logout_success = isset($_GET['logout']) && $_GET['logout'] == 1;
if (isset($_SESSION['admin_id'])) {
    header('Location: admindashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id, username, nama_lengkap, password FROM users WHERE username=? AND role='admin' LIMIT 1");
    if ($stmt === false) {
        $error = 'Query error: ' . $conn->error . '. Pastikan kolom role dan nama_lengkap ada di tabel users.';
    } else {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['admin_nama'] = $row['nama_lengkap'];
                header('Location: admindashboard.php');
                exit();
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan atau bukan admin!';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Login</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body class="overflow-hidden screen-height">
    <nav class="navbar">
    <div class="navbar-inner">
      <h1 class="navbar-brand">Arsintra</h1>
    </div>
  </nav>
  <section class="full-screen-section">
    <div class="background-image">
      <img src="/Arsintra/asset/image/login-bg.png" alt="Login Background" />
    </div>
    <div class="form-container">
      <div class="form-inner">
        <div>
          <h1 class="heading-bold">Hi!</h1>
          <h1 class="heading">Selamat datang kembali</h1>
        </div>
        <?php if ($error): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        <?php if ($logout_success): ?>
        <div class="alert alert-success" style="display:flex;align-items:center;margin-bottom:20px;color:#1a7f37;background:#d4f8e8;border:1px solid #1a7f37;border-radius:8px;padding:12px 20px;font-weight:500;gap:8px;">
            <svg style="width:20px;height:20px;flex-shrink:0;margin-right:8px;" fill="none" stroke="#1a7f37" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Berhasil logout. Silakan login kembali.
        </div>
        <?php endif; ?>
        <form class="form" method="POST" autocomplete="off">
          <div class="form-group">
            <label for="username" style="font-size: 16px;">Username<span class="required">*</span></label><br />
            <input type="text" placeholder="Masukkan username" name="username" required />
          </div>
          <div class="form-group">
            <label for="password" style="font-size: 16px;">Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="password" required />
          </div>
          <div class="button-group">
            <button type="submit" class="btn btn-primary">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</div>
</body>
</html>
