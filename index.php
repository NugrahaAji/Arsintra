<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple validation (you should use proper database validation)
    if ($email === 'admin@arsintra.com' && $password === 'admin123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = 'Admin';
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Email atau kata sandi salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arsintra - Daftar</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <nav class="navbar">
    <div class="navbar-inner">
      <h1 class="navbar-brand">Arsintra</h1>

      <ul class="nav-links">
        <li class="nav-item"><a href="register.php">Daftar</a></li>
        <li class="nav-item btn-login">
          <a href="index.php">Masuk</a>
        </li>
      </ul>

    </div>
  </nav>
  <section class="full-screen-section">
    <div class="background-image">
      <img src="asset/image/login-bg.png" alt="Login Background" />
    </div>

    <div class="form-container">
      <div class="form-inner">
        <div>
          <h1 class="heading-bold">Hi!</h1>
          <h1 class="heading">Selamat datang kembali</h1>
        </div>

        <?php if (isset($error)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
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
        </form>
          <div class="button-group">
            <button type="submit" class="btn btn-primary">Masuk</button>
            <a href="register.php" class="btn btn-secondary">Buat akun</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>