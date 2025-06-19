<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

// 1. Ambil nilai pencarian dari URL dengan aman.
//    Jika tidak ada, $search akan menjadi string kosong.
$search = $_GET['search'] ?? '';

// 2. Siapkan query SQL dasar.
$sql = "
    SELECT id, nomor_surat, nama_surat, kategori, tanggal_masuk, asal_surat, status, file_path
    FROM surat_masuk
";

// Siapkan parameter untuk pencarian yang aman
$search_param = "%" . $search . "%";

// 3. Jika ada input pencarian, tambahkan kondisi WHERE.
if (!empty($search)) {
    // Mencari berdasarkan nomor surat, nama surat, atau asal surat.
    $sql .= " WHERE (nomor_surat LIKE ? OR nama_surat LIKE ? OR asal_surat LIKE ?)";
}

// 4. Tambahkan pengurutan data.
$sql .= " ORDER BY tanggal_masuk DESC";

// 5. Prepare dan execute query.
$stmt = $conn->prepare($sql);

// Jika ada input pencarian, bind parameternya untuk mencegah SQL Injection.
if (!empty($search)) {
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
$surat_masuk = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk - Arsintra</title>
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
                    <div class="search-container">
                        <form action="" method="GET" class="search-form">
                            <input type="text" name="search" placeholder="Cari surat..." value="<?php echo htmlspecialchars($search); ?>">
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

            <!-- Page Content -->
            <main class="page-content">
                <div class="page-header">
                    <h1>Surat Masuk</h1>
                    <a href="tambah-surat-masuk.php" class="btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
                        Tambah
                    </a>
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
                                <?php foreach ($surat_masuk as $index => $surat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($surat['nomor_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['nama_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($surat['kategori']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($surat['tanggal_masuk'])); ?></td>
                                    <td><?php echo htmlspecialchars($surat['asal_surat']); ?></td>
                                    <td>
                                        <?php
                                        $status = $surat['status'];
                                        $badge = '';
                                        $label = '';
                                        if ($status === 'menunggu') {
                                            $badge = 'style="background:#fff6e0;color:#e6a700;border:1px solid #e6a700;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#9888;</span> Menunggu Tindakan';
                                        } elseif ($status === 'selesai') {
                                            $badge = 'style="background:#d4f8e8;color:#1a7f37;border:1px solid #1a7f37;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#10003;</span> Selesai Arsip';
                                        } elseif ($status === 'ditolak') {
                                            $badge = 'style="background:#ffe0e0;color:#d32f2f;border:1px solid #d32f2f;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#10005;</span> Ditolak';
                                        } else {
                                            // Default to 'menunggu' if status is not recognized
                                            $badge = 'style="background:#fff6e0;color:#e6a700;border:1px solid #e6a700;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#9888;</span> Menunggu Tindakan';
                                        }
                                        ?>
                                        <span <?php echo $badge; ?>><?php echo $label; ?></span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="detail-surat-masuk.php?id=<?php echo $surat['id']; ?>" class="btn-detail">Detail</a>
                                            <a href="download-surat.php?id=<?php echo $surat['id']; ?>&type=masuk" class="btn-icon" title="Download">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16.004V17a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1M12 4.5v11m3.5-3.5L12 15.5L8.5 12"/></svg>
                                            </a>
                                            <a href="edit-surat-masuk.php?id=<?php echo $surat['id']; ?>" class="btn-icon" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 21h16M5.666 13.187A2.28 2.28 0 0 0 5 14.797V18h3.223c.604 0 1.183-.24 1.61-.668l9.5-9.505a2.28 2.28 0 0 0 0-3.22l-.938-.94a2.277 2.277 0 0 0-3.222.001z"/></svg>
                                            </a>
                                            <button onclick="deleteSurat(<?php echo $surat['id']; ?>)" class="btn-delete" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#da0700" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="m14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.088 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0"/></svg>
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

  function deleteSurat(id) {
    if (confirm('Apakah Anda yakin ingin menghapus surat ini?')) {
        window.location.href = `hapus-surat-masuk.php?id=${id}`;
    }
  }
</script>
</body>
</html>
