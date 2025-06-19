<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Disposisi Surat - Arsintra</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .radio-group {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.5rem;
        }
        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .radio-option input[type="radio"] {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1></h1>
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
                <a href="./surat-keluar.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Surat Keluar</span>
                </a>
                <a href="./disposisi-surat.php" class="sidebar-item active">
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
        <div class="main-content">
<header class="header">
                <h1></h1>
                <div class="header-actions">
                    <div class="search-container">
                        <form action="" method="GET" class="search-form">
                            <input type="text" name="search" placeholder="Cari akun..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="icon-button">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
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
                            <a href="edit-akun-pengguna.php?id=<?php echo $_SESSION['user_id']; ?>" class="dropdown-item">
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

            <main class="page-content">
                <div class="page-header">
                    <h1>Disposisi Surat</h1>
                </div>

                <?php if (isset($success)): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success); ?>
                    <a href="./disposisi-surat.php">Kembali ke daftar disposisi surat</a>
                </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <div class="form-container-page">
                    <form class="form-grid" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="no_surat">No Surat<span class="required">*</span></label>
                                <input type="text" id="no_surat" name="no_surat" value="001" required>
                            </div>
                            <div class="form-group">
                                <label for="tujuan_disposisi">Tujuan Disposisi<span class="required">*</span></label>
                                <input type="text" id="tujuan_disposisi" name="tujuan_disposisi" value="Kepala Bagian Umum" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama_surat">Nama Surat<span class="required">*</span></label>
                                <input type="text" id="nama_surat" name="nama_surat" value="Pengajuan Kerja Sama" required>
                            </div>
                            <div class="form-group">
                                <label>Tingkat Urgensi<span class="required">*</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="biasa" name="tingkat_urgensi" value="Biasa" checked>
                                        <label for="biasa">Biasa</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="penting" name="tingkat_urgensi" value="Penting">
                                        <label for="penting">Penting</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="sangat_penting" name="tingkat_urgensi" value="Sangat Penting">
                                        <label for="sangat_penting">Sangat Penting</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tanggal_surat_masuk">Tanggal Surat Masuk<span class="required">*</span></label>
                                <input type="text" id="tanggal_surat_masuk" name="tanggal_surat_masuk" value="17 - 02 - 2025" required>
                            </div>
                            <div class="form-group">
                                <label for="pengirim_surat">Pengirim Surat<span class="required">*</span></label>
                                <input type="text" id="pengirim_surat" name="pengirim_surat" value="Dea Delvinata" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="jumlah_lampiran">Jumlah Lampiran<span class="required">*</span></label>
                                <input type="text" id="jumlah_lampiran" name="jumlah_lampiran" value="3 Rangkap" required>
                            </div>
                            <div class="form-group">
                                <label for="file_surat">File Surat<span class="required">*</span></label>
                                <div class="file-input-container">
                                    <input type="file" id="file_surat" name="file_surat" accept=".pdf,.docx,.csv,.png,.jpg" required>
                                    <span class="file-format-note">format image (pdf,docx,csv,png,jpg)</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="isi_disposisi">Isi Disposisi<span class="required">*</span></label>
                            <textarea id="isi_disposisi" name="isi_disposisi" rows="6" required>Surat ini ditujukan untuk meminta tanda tangan dari wakil dekan bidang kemahasiswaan supaya kegiatan bisa berjalan</textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="catatan_tambahan">Catatan Tambahan</label>
                            <textarea id="catatan_tambahan" name="catatan_tambahan" rows="6" placeholder="(opsional)"></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Simpan</button>
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
</script>
</body>
</html>
