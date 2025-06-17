<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$stats = [
    'suratMasuk' => 0,
    'suratKeluar' => 0,
    'disposisi' => 0
];

$stmt = $conn->query("SELECT COUNT(*) as total FROM surat_masuk");
if ($stmt) {
    $result = $stmt->fetch_assoc();
    $stats['suratMasuk'] = $result['total'];
}
$stmt = $conn->query("SELECT COUNT(*) as total FROM surat_keluar");
if ($stmt) {
    $result = $stmt->fetch_assoc();
    $stats['suratKeluar'] = $result['total'];
}
$stmt = $conn->query("SELECT COUNT(*) as total FROM surat_masuk WHERE status = 'Ditolak'");
if ($stmt) {
    $result = $stmt->fetch_assoc();
    $stats['disposisi'] = $result['total'];
}

$disposisiData = [];
$stmt = $conn->query("SELECT nama_surat, deskripsi_surat as catatan FROM surat_masuk WHERE status = 'ditolak' ORDER BY tanggal_masuk DESC LIMIT 3");
if ($stmt) {
    while ($row = $stmt->fetch_assoc()) {
        $disposisiData[] = [
            'nama' => $row['nama_surat'],
            'jumlah' => '1/1',
            'catatan' => $row['catatan'] ?: 'Tidak ada catatan'
        ];
    }
}

$statusData = [];
$stmt = $conn->query("SELECT id, nama_surat, kategori, status FROM surat_masuk ORDER BY tanggal_masuk DESC LIMIT 3");
if ($stmt) {
    while ($row = $stmt->fetch_assoc()) {
        $statusData[] = [
            'no' => 'SM' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
            'nama' => $row['nama_surat'],
            'kategori' => $row['kategori'],
            'status' => ucfirst($row['status'])
        ];
    }
}

$suratKeluarData = [];
$stmt = $conn->query("SELECT id, nama_surat, kategori, status FROM surat_keluar ORDER BY tanggal_keluar DESC LIMIT 3");
if ($stmt) {
    while ($row = $stmt->fetch_assoc()) {
        $suratKeluarData[] = [
            'no' => 'SK' . str_pad($row['id'], 3, '0', STR_PAD_LEFT),
            'nama' => $row['nama_surat'],
            'kategori' => $row['kategori'],
            'status' => ucfirst($row['status'])
        ];
    }
}

$search = $_GET['search'] ?? '';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsintra Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Arsintra</h1>
            </div>
            <nav class="sidebar-nav">
                <a href="./dashboard.php" class="sidebar-item active">
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
                <a href="#" class="sidebar-item" id="logoutButton">
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
                            <a href="edit-akun-pengguna.php?id=<?php echo $_SESSION['admin_id'] ?? $_SESSION['user_id']; ?>" class="dropdown-item">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="#" class="dropdown-item" id="logoutButtonDropdown">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="dashboard">
                <div class="welcome-message">
                    <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
                    <p>Kelola dokumen dan surat dengan mudah melalui dashboard ini.</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Surat Masuk</h3>
                        <div class="stat-value"><?php echo $stats['suratMasuk']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Surat Keluar</h3>
                        <div class="stat-value"><?php echo $stats['suratKeluar']; ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Jumlah Disposisi</h3>
                        <div class="stat-value"><?php echo $stats['disposisi']; ?></div>
                    </div>
                </div>

                <div class="tables-grid">

                    <div class="table-container">
                        <div class="table-header"><h2>Status Surat Masuk Terbaru</h2></div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Surat</th>
                                        <th>Kategori</th>
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
                    <div class="table-container">
                        <div class="table-header"><h2>Status Surat Keluar Terbaru</h2></div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Surat</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($suratKeluarData as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['no']); ?></td>
                                        <td><?php htmlspecialchars($item['nama']); ?></td>
                                        <td><?php htmlspecialchars($item['kategori']); ?></td>
                                        <td><?php htmlspecialchars($item['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-container table-full">
                        <div class="table-header"><h2>Disposisi Terbaru</h2></div>
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
    const logoutButtonSidebar = document.getElementById('logoutButton');
    const logoutButtonDropdown = document.getElementById('logoutButtonDropdown');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogoutButton = document.getElementById('cancelLogout');

    profileButton.addEventListener('click', function(e) {
        e.stopPropagation();
        profileMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.remove('show');
        }
    });

    logoutButtonSidebar.addEventListener('click', function (e) {
        e.preventDefault();
        logoutModal.classList.remove('hidden');
    });

    logoutButtonDropdown.addEventListener('click', function (e) {
        e.preventDefault();
        logoutModal.classList.remove('hidden');
    });

    cancelLogoutButton.addEventListener('click', function () {
        logoutModal.classList.add('hidden');
    });

    logoutModal.addEventListener('click', function (e) {
        if (e.target === logoutModal) {
            logoutModal.classList.add('hidden');
        }
    });
</script>

</body>
</html>
