<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Arsip - Arsintra</title>
  <link rel="stylesheet" href="css/style.css" />
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
        <a href="surat-keluar.php" class="sidebar-item ">
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
        <a href="arsip.php" class="sidebar-item active">
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


    <main class="content">
    <h2>Surat Keluar</h2>
    <div class="grid-container">
        <!-- Kartu Surat -->
        <?php for ($i = 0; $i < 6; $i++): ?>
        <div class="card">
            <h3>Surat Pengajuan Pendanaan</h3>
            <p>18 Maret 2025</p>
            <img src="asset/image/surat-preview.png" alt="Surat" class="surat-image">
            <div class="button-group">
                <button class="btn simpan">
                    <span class="icon">⬇️</span> Simpan
                </button>
                <button class="btn detail">
                    <span class="icon">🔍</span> Detail
                </button>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</main>
</div>
</div>
</body>
</html>
