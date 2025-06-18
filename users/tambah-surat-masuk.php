<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set zona waktu ke Waktu Indonesia Barat untuk tanggal hari ini
    date_default_timezone_set('Asia/Jakarta');

    // --- Mengambil data dari form ---
    $nomor_surat = $_POST['nomor_surat'] ?? '';
    $asal_surat = $_POST['asal_surat'] ?? '';
    $nama_surat = $_POST['nama_surat'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? ''; // Ini adalah tanggal yang tertera di fisik surat
    $petugas_arsip = $_POST['petugas_arsip'] ?? '';
    $jumlah_lampiran = $_POST['jumlah_lampiran'] ?? 0;
    $deskripsi_surat = $_POST['deskripsi_surat'] ?? '';

    // --- Menetapkan nilai berdasarkan aturan baru ---

    // Aturan 1: Tanggal Surat disamakan dengan Tanggal Masuk
    $tanggal_surat = $tanggal_masuk;

    // Aturan 2: Tanggal Terima adalah tanggal hari ini (saat data diinput)
    $tanggal_terima = date('Y-m-d');

    // Aturan 3: Perihal diisi dengan Kategori
    $perihal = $kategori;

    // Kolom 'pengirim' disamakan dengan asal_surat
    $pengirim = $asal_surat; 

    $status = 'menunggu';

    // Validasi input (hanya untuk field yang diisi manual)
    if (empty($nomor_surat) || empty($asal_surat) || empty($nama_surat) || empty($kategori) || empty($tanggal_masuk) || empty($petugas_arsip)) {
        $error = 'Semua field dengan tanda * harus diisi';
    } else {
        // Handle file upload
        $file_path = '';
        if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/surat_masuk/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = $_FILES['file_surat']['name'];
            $file_tmp = $_FILES['file_surat']['tmp_name'];
            $new_file_name = uniqid() . '_' . basename($file_name);
            $file_path = 'uploads/surat_masuk/' . $new_file_name;

            if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                $error = 'Gagal mengupload file';
            }
        }

        if (empty($error)) {
            try {
                // Query INSERT tetap sama seperti yang terakhir kita buat
                $stmt = $conn->prepare(
                    "INSERT INTO surat_masuk (nomor_surat, asal_surat, nama_surat, kategori, tanggal_masuk, petugas_arsip, jumlah_lampiran, deskripsi_surat, status, created_by, file_path, tanggal_surat, tanggal_terima, pengirim, perihal) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if ($stmt === false) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }

                $user_id = $_SESSION['user_id'] ?? null; // Pastikan user_id ada di session
                
                $stmt->bind_param(
                    "ssssssisssissss", 
                    $nomor_surat, $asal_surat, $nama_surat, $kategori, $tanggal_masuk, 
                    $petugas_arsip, $jumlah_lampiran, $deskripsi_surat, $status, $user_id, 
                    $file_path, $tanggal_surat, $tanggal_terima, $pengirim, $perihal
                );

                if (!$stmt->execute()) {
                    throw new Exception("Error executing statement: " . $stmt->error);
                }

                header('Location: surat-masuk.php?success=1');
                exit();
            } catch (Exception $e) {
                $error = 'Error: ' . $e->getMessage();
                error_log("Error in tambah-surat-masuk.php: " . $e->getMessage());
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Masuk - Arsintra</title>
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
                <a href="./surat-masuk.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Surat Masuk</span>
                </a>
                <a href="./surat-keluar.php" class="sidebar-item">
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
                    <div class="profile-dropdown">
                        <button class="icon-button" id="profileButton">
                            <div class="avatar" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                                <span><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                            </div>
                        </button>
                        <div class="dropdown-menu" id="profileMenu">
                            <div class="dropdown-header">
                                <div class="user-info">
                                    <div class="avatar" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                                        <span><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                                        <span class="user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="edit-akun-pengguna.php?id=<?php echo $_SESSION['admin_id']; ?>" class="dropdown-item">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <div class="page-header">
                    <h1>Tambah Surat Masuk</h1>
                    <div class="header-actions">
                        <a href="./surat-masuk.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="form-container-page" style="max-width: 100%; padding: 20px;">
                    <?php if ($success): ?>
                        <div class="alert alert-success" style="display:flex;align-items:center;margin-bottom:20px;color:#1a7f37;background:#d4f8e8;border:1px solid #1a7f37;border-radius:8px;padding:12px 20px;font-weight:500;gap:8px;">
                            <svg style="width:20px;height:20px;flex-shrink:0;margin-right:8px;" fill="none" stroke="#1a7f37" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger" style="display:flex;align-items:center;margin-bottom:20px;color:#d32f2f;background:#ffe0e0;border:1px solid #d32f2f;border-radius:8px;padding:12px 20px;font-weight:500;gap:8px;">
                            <svg style="width:20px;height:20px;flex-shrink:0;margin-right:8px;" fill="none" stroke="#d32f2f" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data" class="form" style="background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="nomor_surat">No Surat *</label>
                                <input type="text" id="nomor_surat" name="nomor_surat" required>
                            </div>
                            <div class="form-group">
                                <label for="asal_surat">Asal Surat *</label>
                                <input type="text" id="asal_surat" name="asal_surat" required>
                            </div>
                        </div>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="nama_surat">Nama Surat *</label>
                                <input type="text" id="nama_surat" name="nama_surat" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori *</label>
                                <input type="text" id="kategori" name="kategori" required>
                            </div>
                        </div>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk *</label>
                                <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>
                            </div>
                            <div class="form-group">
                                <label for="petugas_arsip">Petugas Arsip *</label>
                                <input type="text" id="petugas_arsip" name="petugas_arsip" required>
                            </div>
                        </div>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="jumlah_lampiran">Jumlah Lampiran *</label>
                                <input type="text" id="jumlah_lampiran" name="jumlah_lampiran" required>
                            </div>
                            <div class="form-group">
                                <label for="file_surat">Scan Surat *</label>
                                <input type="file" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.csv,.png,.jpg" required>
                                <span class="file-format-note">format image (pdf,doc,docx,csv,png,jpg)</span>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="deskripsi_surat">Deskripsi Surat *</label>
                            <textarea id="deskripsi_surat" name="deskripsi_surat" rows="3" required style="width: 100%;"></textarea>
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
    const profileButton = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');

    profileButton.addEventListener('click', function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.remove('show');
        }
    });
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
