<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$stmt = $conn->prepare("
    SELECT id, nomor_surat, nama_surat, kategori, tanggal_masuk, asal_surat, status 
    FROM surat_masuk 
    ORDER BY tanggal_masuk DESC
");
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
                    <div class="avatar" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                        <span><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content">
                <div class="page-header">
                    <h1>Surat Masuk</h1>
                    <a href="./tambah-surat-masuk.php" class="btn-save">
                        <span>Tambah +</span>
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
                                        if ($status === 'selesai' || $status === 'Selesai Arsip') {
                                            $badge = 'style="background:#d4f8e8;color:#1a7f37;border:1px solid #1a7f37;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#10003;</span> Selesai Arsip';
                                        } elseif ($status === 'menunggu' || $status === 'Menunggu Tindakan') {
                                            $badge = 'style="background:#fff6e0;color:#e6a700;border:1px solid #e6a700;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#9888;</span> Menunggu Tindakan';
                                        } elseif ($status === 'ditolak' || $status === 'Ditolak') {
                                            $badge = 'style="background:#ffe0e0;color:#d32f2f;border:1px solid #d32f2f;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;"';
                                            $label = '<span style="font-size:18px;">&#9888;</span> Ditolak';
                                        } else {
                                            $badge = 'style="background:#eee;color:#333;padding:2px 12px;border-radius:16px;"';
                                            $label = htmlspecialchars($status);
                                        }
                                        echo '<span '.$badge.'>'.$label.'</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="detail-surat-masuk.php?id=<?php echo $surat['id']; ?>" class="btn-icon" title="Detail">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="download-surat.php?id=<?php echo $surat['id']; ?>" class="btn-icon" title="Download">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4m4-5l5 5 5-5m-5 5V3"></path>
                                                </svg>
                                            </a>
                                            <a href="edit-surat-masuk.php?id=<?php echo $surat['id']; ?>" class="btn-icon" title="Edit">
                                                <svg class="icon" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </a>
                                            <button onclick="deleteSurat(<?php echo $surat['id']; ?>)" class="btn-icon" title="Hapus">
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
