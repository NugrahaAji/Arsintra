<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arsintra - Masuk</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <nav class="navbar">
    <div class="navbar-inner">
      <h1 class="navbar-brand">Arsintra</h1>

      <ul class="nav-links">
        <li class="nav-item btn-login"> <a href="#">Masuk</a>
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
            <label for="username">username<span class="required">*</span></label><br />
            <input type="username" placeholder="Masukkan username" name="username" required />
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi<span class="required">*</span></label><br />
            <input type="password" placeholder="Masukkan kata sandi" name="password" required />
          </div>

          <div class="button-group">
            <button type="submit" class="btn btn-primary">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>