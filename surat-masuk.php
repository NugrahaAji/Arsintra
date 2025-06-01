<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit();
// }

// Sample data for Surat Masuk
$suratMasukData = [
    [
        'no' => '001',
        'nama_surat' => 'Poposal Kegiatan',
        'kategori' => 'Poposal',
        'tanggal_masuk' => '17-07-2025',
        'asal_surat' => 'Himakorn FMIPA UNILA',
        'status' => 'Selesai Arsip',
        'status_color' => 'success'
    ],
    [
        'no' => '002',
        'nama_surat' => 'Pegajuan Dana Lab',
        'kategori' => 'Pendanaan',
        'tanggal_masuk' => '16-10-2024',
        'asal_surat' => 'Kepala Badan Khusus',
        'status' => 'Menunggu Tindakan',
        'status_color' => 'warning'
    ],
    [
        'no' => '003',
        'nama_surat' => 'Pegajuan Dana Lab',
        'kategori' => 'Pendanaan',
        'tanggal_masuk' => '16-10-2024',
        'asal_surat' => 'Kepala Badan Khusus',
        'status' => 'Selesai Arsip',
        'status_color' => 'success'
    ],
    [
        'no' => '004',
        'nama_surat' => 'Pegajuan Dana Lab',
        'kategori' => 'Pendanaan',
        'tanggal_masuk' => '16-10-2024',
        'asal_surat' => 'Kepala Badan Khusus',
        'status' => 'Ditolak',
        'status_color' => 'danger'
    ],
    [
        'no' => '005',
        'nama_surat' => 'Pegajuan Dana Lab',
        'kategori' => 'Pendanaan',
        'tanggal_masuk' => '16-10-2024',
        'asal_surat' => 'Kepala Badan Khusus',
        'status' => 'Selesai Arsip',
        'status_color' => 'success'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk - Arsintra</title>
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
                <a href="surat-masuk.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Surat Masuk</span>
                </a>
                <a href="#" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Surat Keluar</span>
                </a>
                <a href="#" class="sidebar-item">
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
                            <path d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 00-15 0v5h5l-5 5-5-5h5V7a9.5 9.5 0 0119 0v10z"></path>
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
                    <h1>Surat Masuk</h1>
                    <button class="btn-add">
                        <span>Tambah +</span>
                    </button>
                </div>

                <!-- Surat Masuk Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Surat</th>
                                    <th>Kategori Surat</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Asal Surat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suratMasukData as $surat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($surat['no']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['nama_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['kategori']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['tanggal_masuk']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['asal_surat']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $surat['status_color']; ?>">
                                            <?php if ($surat['status_color'] === 'success'): ?>
                                                <svg class="status-icon" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php elseif ($surat['status_color'] === 'warning'): ?>
                                                <svg class="status-icon" viewBox="0 0 24 24">
                                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="status-icon" viewBox="0 0 24 24">
                                                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($surat['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-detail">Detail</button>
                                            <button class="btn-icon" title="Download">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4m4-5l5 5 5-5m-5 5V3"></path>
                                                </svg>
                                            </button>
                                            <button class="btn-icon" title="Edit">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </button>
                                            <button class="btn-icon btn-delete" title="Delete">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
</body>
</html>
