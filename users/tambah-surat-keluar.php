<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_surat = $_POST['nomor_surat'] ?? '';
    $nama_surat = $_POST['nama_surat'] ?? '';
    $tanggal_keluar = $_POST['tanggal_keluar'] ?? '';
    $di_keluarkan = $_POST['di_keluarkan'] ?? '';
    $tujuan_surat = $_POST['tujuan_surat'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $deskripsi_surat = $_POST['deskripsi_surat'] ?? '';
    $status = 'draft';

    // Handle file upload
    $file_path = '';
    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/surat_keluar/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['file_surat']['name']);
        $target_path = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['file_surat']['tmp_name'], $target_path)) {
            $file_path = 'uploads/surat_keluar/' . $file_name;
        }
    }

    if (empty($nomor_surat) || empty($nama_surat) || empty($tanggal_keluar) || empty($di_keluarkan) || empty($tujuan_surat) || empty($kategori) || empty($deskripsi_surat)) {
        $error = "Semua field harus diisi";
    } else {
        try {
            $user_id = (int)$_SESSION['user_id'];

            $stmt = $conn->prepare("INSERT INTO surat_keluar (nomor_surat, nama_surat, tanggal_keluar, di_keluarkan, tujuan_surat, kategori, deskripsi_surat, file_path, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("sssssssssi", 
                $nomor_surat, 
                $nama_surat, 
                $tanggal_keluar, 
                $di_keluarkan, 
                $tujuan_surat, 
                $kategori, 
                $deskripsi_surat, 
                $file_path, 
                $status, 
                $user_id
            );

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $success = "Surat keluar berhasil ditambahkan";
            header("Location: surat-keluar.php?success=1");
            exit();
        } catch (Exception $e) {
            error_log("Error in tambah-surat-keluar.php: " . $e->getMessage());
            $error = "Gagal menambahkan surat keluar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Keluar - Arsintra</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Arsintra</h1>
            </div>
            <nav class="sidebar-nav">
                <a href="./dashboard.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="./surat-masuk.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Surat Masuk</span>
                </a>
                <a href="./surat-keluar.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Surat Keluar</span>
                </a>
                <a href="./disposisi-surat.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Disposisi Surat</span>
                </a>
                <a href="./arsip.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Arsip</span>
                </a>
                <a href="./logout.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1></h1>
                <div class="header-actions">
                    <button class="icon-button">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </button>
                    <button class="icon-button">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <div class="avatar" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                        <span><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <div class="page-header">
                    <h1>Tambah Surat Keluar</h1>
                    <div class="header-actions">
                        <a href="./surat-keluar.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="form-container-page">
                    <?php if ($success): ?>
                        <div class="alert alert-success" style="margin-bottom:20px; color:#1a7f37; background:#d4f8e8; border:1px solid #1a7f37; border-radius:8px; padding:12px 20px; font-weight:500;">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger" style="margin-bottom:20px; color:#d32f2f; background:#ffe0e0; border:1px solid #d32f2f; border-radius:8px; padding:12px 20px; font-weight:500;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data" class="form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nomor_surat">No Surat*</label>
                                <input type="text" id="nomor_surat" name="nomor_surat" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_surat">Nama Surat *</label>
                                <input type="text" id="nama_surat" name="nama_surat" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tanggal_keluar">Tanggal Keluar *</label>
                                <input type="date" id="tanggal_keluar" name="tanggal_keluar" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="di_keluarkan">Dikeluarkan Oleh *</label>
                                <input type="text" id="di_keluarkan" name="di_keluarkan" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="tujuan_surat">Tujuan Surat *</label>
                                <input type="text" id="tujuan_surat" name="tujuan_surat" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori *</label>
                                <input type="text" id="kategori" name="kategori" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="file_surat">Scan Surat*</label>
                                <input type="file" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.csv,.png,.jpg" required>
                                <span class="file-format-note">format image (pdf,doc,docx,csv,png,jpg)</span>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="deskripsi_surat">Deskripsi Surat *</label>
                            <textarea id="deskripsi_surat" name="deskripsi_surat" required></textarea>
                        </div>
                        <div class="button-group" style="display: flex; justify-content: flex-end;">
                            <button type="submit" class="btn btn-primary" style="width: fit-content; min-width: 120px;">Tambah</button>
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
      <a href="./logout.php" class="btn-logout">Keluar</a>
    </div>
  </div>
</div>
<script>
  const logoutBtn = document.querySelector('.sidebar-item[href="./logout.php"]');
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
