<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit();
// }

// Sample data for Disposisi Surat
$disposisiData = [
    [
        'no' => '001',
        'nama_surat' => 'Poposal Kegiatan',
        'perihal_surat' => 'Revisi Kontrak Kerjasama',
        'tanggal_masuk' => '17-07-2025',
        'tujuan_surat' => 'Kepala Bagian Umum',
        'komentar' => 'Kesalahan dalam penulisan nama dan gelar'
    ],
    [
        'no' => '002',
        'nama_surat' => 'Pegajuan Dana Lab',
        'perihal_surat' => 'Undangan Rapat Koordinasi',
        'tanggal_masuk' => '16-10-2024',
        'tujuan_surat' => 'Kepala Badan Khusus',
        'komentar' => 'Kesalahan dalam penulisan nama dan gelar'
    ],
    [
        'no' => '003',
        'nama_surat' => 'Pegajuan Dana Lab',
        'perihal_surat' => 'Permohonan Anggaran',
        'tanggal_masuk' => '16-10-2024',
        'tujuan_surat' => 'Kepala Bagian Keuanagan',
        'komentar' => 'Kesalahan dalam penulisan nama dan gelar'
    ],
    [
        'no' => '004',
        'nama_surat' => 'Pegajuan Dana Lab',
        'perihal_surat' => 'Persetujuan Cuti',
        'tanggal_masuk' => '16-10-2024',
        'tujuan_surat' => 'Kepala Bagian Umum',
        'komentar' => 'Kesalahan dalam penulisan nama dan gelar'
    ],
    [
        'no' => '005',
        'nama_surat' => 'Pegajuan Kerja Sama',
        'perihal_surat' => 'Pengajuan Pembelian',
        'tanggal_masuk' => '16-10-2024',
        'tujuan_surat' => 'Kepala Bagian Administrasi',
        'komentar' => 'Kesalahan dalam penulisan nama dan gelar'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposisi Surat - Arsintra</title>
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
                <a href="surat-keluar.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Surat Keluar</span>
                </a>
                <a href="disposisi-surat.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>Disposisi Surat</span>
                </a>
                <a href="arsip.php" class="sidebar-item">
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
                    <h1>Disposisi Surat</h1>
                    <a href="tambah-disposisi-surat.php" class="btn-save">
                        <span>Tambah +</span>
                    </a>
                </div>

                <!-- Disposisi Surat Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Surat</th>
                                    <th>Perihal Surat</th>
                                    <th>Tanggal Surat Masuk</th>
                                    <th>Tujuan Surat</th>
                                    <th>Komentar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($disposisiData as $disposisi): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($disposisi['no']); ?></td>
                                    <td><?php echo htmlspecialchars($disposisi['nama_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($disposisi['perihal_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($disposisi['tanggal_masuk']); ?></td>
                                    <td><?php echo htmlspecialchars($disposisi['tujuan_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($disposisi['komentar']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="detail-disposisi-surat.php?id=<?php echo urlencode($disposisi['no']); ?>" class="btn-detail">Detail</a>
                                            <button class="btn-delete" title="Edit">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </button>
                                            <button class="btn-delete" title="Delete">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
