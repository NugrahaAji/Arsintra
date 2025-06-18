<?php
require_once '../config.php';
require_once '../config/session.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama_lengkap'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Username atau password salah";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsintra - Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <h1 class="navbar-brand">Arsintra</h1>

        </div>
    </nav>
    <section class="full-screen-section">
        <div class="background-image">
            <img src="../asset/image/login-bg.png" alt="Login Background" />
        </div>

        <div class="form-container" style="margin-top: 50px;">
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

                <form class="form" method="POST">
                    <div class="form-group">
                        <label for="username">Username<span class="required">*</span></label><br />
                        <input type="text" placeholder="Masukkan Username" name="username" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi<span class="required">*</span></label><br />
                        <input type="password" placeholder="Masukkan kata sandi" name="password" required />
                    </div>

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
