<?php
session_start();

// Clear any existing session data to ensure clean access
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arsintra - Pilih Role</title>
  <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <nav class="navbar">
    <div class="navbar-inner">
      <h1 class="navbar-brand">Arsintra</h1>
    </div>
  </nav>
  <section class="full-screen-section">
    <div class="background-image">
      <img src="./asset/image/login-bg.png" alt="Login Background" />
    </div>
    <div class="form-container" style="margin-top: 50px;">
      <div class="form-inner">
        <div>
          <h1 class="heading-bold" style="text-align:center;">Selamat Datang!</h1>
          <h1 class="heading" style="text-align:center;">Silakan pilih role Anda</h1>
        </div>
        <div class="role-selection" style="display:flex;gap:32px;justify-content:center;flex-wrap:wrap;margin-top:32px;">
          <div class="role-card" style="width:300px;box-shadow:0 4px 16px rgba(0,0,0,0.08);border-radius:16px;padding:2rem 1.5rem;text-align:center;">
            <h2 style="margin-bottom:1rem;">Admin</h2>
            <p style="margin-bottom:2rem;">Login sebagai administrator untuk mengelola sistem</p>
            <a href="./admin/adminlogin.php" class="btn btn-primary" style="width:70%;margin:0 auto;">Login Admin</a>
          </div>
          <div class="role-card" style="width:300px;box-shadow:0 4px 16px rgba(0,0,0,0.08);border-radius:16px;padding:2rem 1.5rem;text-align:center;">
            <h2 style="margin-bottom:1rem;">Petugas Arsip</h2>
            <p style="margin-bottom:2rem;">Login sebagai petugas untuk mengelola arsip</p>
            <a href="./users/login.php" class="btn btn-secondary" style="width:70%;margin:0 auto;">Login Petugas</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>