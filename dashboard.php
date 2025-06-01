<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit();
// }

// Sample data
$stats = [
    'suratMasuk' => 0,
    'suratKeluar' => 0,
    'disposisi' => 0
];

$disposisiData = [
    [
        'nama' => 'Nugraha Aji',
        'jumlah' => '4/5',
        'catatan' => 'Barangnya sesuai dan sesuai dengan yang di deskripsi dan dalam kondisi baik.'
    ],
    [
        'nama' => 'Nugroho Ija',
        'jumlah' => '4/5',
        'catatan' => 'Barangnya sesuai dan sesuai dengan yang di deskripsi dan dalam kondisi baik.'
    ],
    [
        'nama' => 'Nugroho Ijo',
        'jumlah' => '5/5',
        'catatan' => 'Sempurna'
    ]
];

$statusData = [
    [
        'no' => 'B01',
        'nama' => 'Printer Epson E323',
        'kategori' => 'Barang',
        'status' => 'Selesai Arsip'
    ],
    [
        'no' => 'B02',
        'nama' => 'Printer Epson E323',
        'kategori' => 'Barang',
        'status' => 'Menunggu Tindakan'
    ],
    [
        'no' => 'B03',
        'nama' => 'Printer Epson E323',
        'kategori' => 'Barang',
        'status' => 'Ditolak'
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsintra Dashboard</title>
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
                <a href="#" class="sidebar-item active">
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

            <!-- Dashboard Content -->
            <main class="dashboard">
                <!-- Welcome Message -->
                <div class="welcome-message">
                    <!--<h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>-->
                    <p>Kelola dokumen dan surat dengan mudah melalui dashboard ini.</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Surat Masuk</h3>
                        <p class="stat-value"><?php echo $stats['suratMasuk']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Surat Keluar</h3>
                        <p class="stat-value"><?php echo $stats['suratKeluar']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Jumlah Disposisi</h3>
                        <p class="stat-value"><?php echo $stats['disposisi']; ?></p>
                    </div>
                </div>

                <!-- Tables -->
                <div class="tables-grid">
                    <!-- Disposisi Table -->
                    <div class="table-container disposisi-table">
                        <div class="table-header">
                            <h2>Disposisi</h2>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nama Surat</th>
                                        <th>Jumlah</th>
                                        <th>Catatan Disposisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($disposisiData as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($item['jumlah']); ?></td>
                                        <td><?php echo htmlspecialchars($item['catatan']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status Surat Masuk Table -->
                    <div class="table-container status-table">
                        <div class="table-header">
                            <h2>Status Surat Masuk</h2>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No   .</th>
                                        <th>Nama Surat</th>
                                        <th>Kategori Surat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($statusData as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['no']); ?></td>
                                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($item['kategori']); ?></td>
                                        <td><?php echo htmlspecialchars($item['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
