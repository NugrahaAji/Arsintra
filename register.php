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
        <li><a href="/signin" class="btn-login">Daftar</a></li>
        <li class="nav-item">
          <a href="/login">Masuk</a>
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
          <h1 class="heading-bold">Buat Akunmu!</h1>
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

          <div class="form-group">
            <label for="password">Konfirmasi Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="password" required />
          </div>

        </form>

        <div class="button-group">
          <a href="#" class="btn btn-primary">Selanjutnya</a>
          <a href="/signin" class="btn btn-secondary">Sudah Punya Akun</a>
        
        </div>
      </div>
    </div>
  </section>
</body>
</html>
