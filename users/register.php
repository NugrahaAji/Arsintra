<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Konfirmasi kata sandi tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Kata sandi minimal 6 karakter!';
    } else {
        $success = 'Akun berhasil dibuat! Silakan masuk.';
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

      <ul class="nav-links">
        <li class="nav-item btn-login"> <a href="./register.php">Daftar</a>
        </li>
        <li class="nav-item"> <a href="../dashboard.php">Masuk</a>
        </li>
      </ul>

    </div>
  </nav>
  <section class="full-screen-section">
    <div class="background-image">
      <img src="/Arsintra/asset/image/login-bg.png" alt="Login Background" />
    </div>

    <div class="form-container" style="margin-top: 50px;">
      <div class="form-inner">
        <div>
          <h1 class="heading-bold">Buat Akunmu!</h1>
        </div>

        <?php if (isset($error)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
        <div class="success-message">
          <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>

        <form class="form" method="POST">
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
            <a href="../login.php" class="btn btn-secondary">Sudah Punya Akun</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
