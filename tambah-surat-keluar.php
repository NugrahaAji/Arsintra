<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit();
// }

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data here
    $no_surat = $_POST['no_surat'] ?? '';
    $nama_surat = $_POST['nama_surat'] ?? '';
    $tanggal_keluar = $_POST['tanggal_keluar'] ?? '';
    $di_keluarkan = $_POST['di_keluarkan'] ?? '';
    $tujuan_surat = $_POST['tujuan_surat'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $deskripsi_surat = $_POST['deskripsi_surat'] ?? '';
    
    // Handle file upload
    if (isset($_FILES['scan_surat']) && $_FILES['scan_surat']['error'] === UPLOAD_ERR_OK) {
        // File upload logic here
        $upload_dir = 'uploads/';
        $file_name = $_FILES['scan_surat']['name'];
        $file_tmp = $_FILES['scan_surat']['tmp_name'];
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Move uploaded file
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $success = 'Surat keluar berhasil ditambahkan!';
        } else {
            $error = 'Gagal mengupload file!';
        }
    }
    
    // In a real application, you would save to database here
    if (!isset($error)) {
        $success = 'Surat keluar berhasil ditambahkan!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat Keluar - Arsintra</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Arsintra</h1>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="surat-masuk.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Surat Masuk</span>
                </a>
                <a href="surat-keluar.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Surat Keluar</span>
                </a>
                <a href="disposisi-surat.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Disposisi Surat</span>
                </a>
                <a href="#" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Arsip</span>
                </a>
                <a href="logout.php" class="sidebar-item">
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
                    <!-- <div class="avatar" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                        <span><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    </div> -->
                    <div class="avatar"></div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <div class="page-header">
                    <h1>Surat Keluar</h1>
                    <div class="header-actions">
                        <a href="surat-keluar.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <?php if (isset($success)): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="surat-keluar.php">Kembali ke daftar surat keluar</a>
                </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <!-- Form -->
                <div class="form-container-page">
                    <form class="form-grid" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="no_surat">No Surat<span class="required">*</span></label>
                                <input type="text" id="no_surat" name="no_surat" value="001" required>
                            </div>
                            <div class="form-group">
                                <label for="tujuan_surat">Tujuan Surat<span class="required">*</span></label>
                                <input type="text" id="tujuan_surat" name="tujuan_surat" value="Himakorn FMIPA UNILA" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama_surat">Nama Surat<span class="required">*</span></label>
                                <input type="text" id="nama_surat" name="nama_surat" value="Proposal Kegiatan Pelatihan Mata" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori<span class="required">*</span></label>
                                <input type="text" id="kategori" name="kategori" value="Poposal" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tanggal_keluar">Tanggal Keluar<span class="required">*</span></label>
                                <input type="text" id="tanggal_keluar" name="tanggal_keluar" value="17 - 02 - 2025" required>
                            </div>
                            <div class="form-group">
                                <label for="di_keluarkan">Di Keluarkan<span class="required">*</span></label>
                                <input type="text" id="di_keluarkan" name="di_keluarkan" value="Ketua Himakorn" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="jumlah_lampiran">Jumlah Lampiran<span class="required">*</span></label>
                                <input type="text" id="jumlah_lampiran" name="jumlah_lampiran" value="3 Rangkap" required>
                            </div>
                            <div class="form-group">
                                <label for="scan_surat">Scan Surat<span class="required">*</span></label>
                                <div class="file-input-container">
                                    <input type="file" id="scan_surat" name="scan_surat" accept=".pdf,.docx,.csv,.png,.jpg" required>
                                    <span class="file-format-note">format image (pdf,docx,csv,png,jpg)</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="deskripsi_surat">Deskripsi Surat<span class="required">*</span></label>
                            <textarea id="deskripsi_surat" name="deskripsi_surat" rows="6" required>Surat ini ditujukan untuk meminta tanda tangan dari wakil dekan bidang kemahasiswaan supaya kegiatan bisa berjalan</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Simpan</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
