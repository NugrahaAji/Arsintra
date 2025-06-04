<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php');
//     exit();
// }

// Sample data for Surat Masuk
$akunPengguna = [
    [
        'id' => '001',
        'username' => 'presidium',
        'nama' => 'Presidium Himakom',
        'kategori' => 'User',
        'email' => 'presiHimakom@gmail.com',
        'password' => 'makinjaya'
    ],
    [
        'id' => '002',
        'username' => 'bansus',
        'nama' => 'Badan Khusus Himakom',
        'kategori' => 'User',
        'email' => 'bansusiHimakom@gmail.com',
        'password' => 'susss'
    ],
    [
        'id' => '003',
        'username' => 'Kaderisasi Himakom',
        'nama' => 'kader',
        'kategori' => 'User',
        'email' => 'kaderHimakom@gmail.com',
        'password' => 'derrr'
    ],
    [
        'id' => '004',
        'username' => 'keilmuan',
        'nama' => 'Keilmuan Himakom',
        'kategori' => 'User',
        'email' => 'keilHimakom@gmail.com',
        'password' => 'ilmu'
    ],
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
                <a href="admindashboard.php" class="sidebar-item active">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
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
                    <h1>Kelola Akun</h1>
                    <a href="tambahakun.php" class="btn-save">
                        <span>Tambah +</span>
                    </a>
                </div>

                <!-- Surat Masuk Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Kategori</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($akunPengguna as $akun): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($akun['id']); ?></td>
                                    <td><?php echo htmlspecialchars($akun['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($akun['username']); ?></td>
                                    <td><?php echo htmlspecialchars($akun['email']); ?></td>
                                    <td><?php echo htmlspecialchars($akun['kategori']); ?></td>
                                    <td><?php echo htmlspecialchars($akun['password']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="btn-delete" title="Edit" href="edit-akun-pengguna.php">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </a>
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
