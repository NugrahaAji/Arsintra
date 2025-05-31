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
        <li class="nav-item"><a href="/signin">Daftar</a></li>
        <li>
          <a href="/login" class="btn-login">Masuk</a>
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

        <form class="form">
          <div class="form-group">
            <label for="email">Email<span class="required">*</span></label><br />
            <input type="email" placeholder="Masukkan Email" name="email" required />
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="password" required />
          </div>
        </form>

        <a href="#" class="forgot-password">Lupa kata sandi?</a>

        <div class="button-group">
          <a href="#" class="btn btn-primary">Masuk</a>
          <a href="/signin" class="btn btn-secondary">Buat akun</a>
        
        </div>
      </div>
    </div>
  </section>
</body>
</html>
