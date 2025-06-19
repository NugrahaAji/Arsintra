<?php
session_start();

$disposisi_id = $_GET['id'] ?? '001';

$disposisiData = [
    '001' => [
        'no_surat' => '001',
        'nama_surat' => 'Proposal Kegiatan Pelatihan Mata',
        'asal_surat' => 'Himakorn FMIPA UNILA',
        'kategori' => 'Proposal',
        'tanggal_keluar' => '17 - 02 - 2025',
        'tujuan_surat' => 'Dea Delvinata',
        'isi_disposisi' => 'Surat ini ditujukan untuk meminta tanda tangan dari wakil dekan bidang kemahasiswaan supaya kegiatan bisa berjalan',
        'jumlah_lampiran' => '3 Rangkap',
        'file_path' => 'asset/image/sample-document.png'
    ]
];

$disposisi = $disposisiData[$disposisi_id] ?? $disposisiData['001'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Disposisi Surat - Arsintra</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
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
                    <div class="header-actions">
                        <a href="disposisi-surat.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="detail-container">
                    <div class="document-section">
                        <h3>Foto Bukti Usaha</h3>
                        <div class="document-image">
                            <img src="/Arsintra/asset/image/sample-document.png" alt="Document Scan" />
                        </div>
                    </div>

                    <div class="detail-form">
                        <div class="form-row">
                            <div class="detail-group">
                                <label>No Surat</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['no_surat']); ?></div>
                            </div>
                            <div class="detail-group">
                                <label>Asal Surat</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['asal_surat']); ?></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="detail-group">
                                <label>Nama Surat</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['nama_surat']); ?></div>
                            </div>
                            <div class="detail-group">
                                <label>Kategori</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['kategori']); ?></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="detail-group">
                                <label>Tanggal Keluar</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['tanggal_keluar']); ?></div>
                            </div>
                            <div class="detail-group">
                                <label>Tujuan Surat</label>
                                <div class="detail-value"><?php echo htmlspecialchars($disposisi['tujuan_surat']); ?></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="detail-group">
                                <label>Isi Disposisi</label>
                                <div class="detail-value description"><?php echo htmlspecialchars($disposisi['isi_disposisi']); ?></div>
                            </div>
                            <div class="detail-group">
                                <label>Jumlah Lampiran</label>
                                <div class="detail-value description"><?php echo htmlspecialchars($disposisi['jumlah_lampiran']); ?></div>
                            </div>
                        </div>
                    </div>
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
      <a href="logout.php" class="btn-logout">Keluar</a>
    </div>
  </div>
</div>
<script>

  const logoutBtn = document.querySelector('.sidebar-item[href="logout.php"]');
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
