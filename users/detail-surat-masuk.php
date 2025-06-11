<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;

// Get surat data
$stmt = $conn->prepare("
    SELECT sm.*, u.nama_lengkap as created_by_name 
    FROM surat_masuk sm 
    LEFT JOIN users u ON sm.created_by = u.id 
    WHERE sm.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();

if (!$surat) {
    header('Location: surat-masuk.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Masuk - Arsintra</title>
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

        <div class="main-content">
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

            <main class="content">
            <div class="page-header">
                    <h1>Detail Surat Masuk</h1>
                    <div class="header-actions">
                        <a href="./surat-masuk.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
                <div style="background:#fafafa;padding:32px 24px 24px 24px;border-radius:18px;box-shadow:0 2px 16px #0001;max-width:1100px;margin:auto;display:flex;flex-direction:column;gap:32px;">
                    <div>
                        <label style="font-weight:500;margin-bottom:20px;display:block;">Foto Bukti Usaha</label>
                        <?php
                        $file_path = $surat['file_path'];
                        $is_image = false;
                        if ($file_path) {
                            $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                            $is_image = in_array($ext, ['jpg','jpeg','png','gif']);
                        }
                        if ($file_path && $is_image): ?>
                            <img src="../<?php echo htmlspecialchars($file_path); ?>" alt="Foto Surat" style="max-width:700px;max-height:500px;border-radius:8px;border:1px solid #ddd;box-shadow:0 2px 8px #0001;">
                        <?php elseif ($file_path): ?>
                            <a href="../<?php echo htmlspecialchars($file_path); ?>" target="_blank" class="btn btn-primary" style="margin-top:16px;display:inline-block;">Download File</a>
                        <?php else: ?>
                            <div style="color:#888;font-style:italic;">Tidak ada file</div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div style="display:flex;gap:16px;margin-bottom:16px;" style="margin-bottom:20px;">
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">No Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['nomor_surat']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Asal Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['asal_surat']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                        </div>
                        <div style="display:flex;gap:16px;margin-bottom:16px;">
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Nama Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['nama_surat']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Kategori</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['kategori']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                        </div>
                        <div style="display:flex;gap:16px;margin-bottom:16px;">
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Tanggal Masuk</label>
                                <input type="text" value="<?php echo date('d - m - Y', strtotime($surat['tanggal_masuk'])); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Petugas Arsip</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['petugas_arsip']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
                            </div>
                        </div>
                        <div style="display:flex;gap:16px;margin-bottom:16px;">
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Deskripsi Surat</label>
                                <textarea readonly style="width:100%;min-height:60px;resize:vertical;"><?php echo htmlspecialchars($surat['deskripsi_surat']); ?></textarea>
                            </div>
                            <div style="flex:1;min-width:180px;">
                                <label style="font-weight:500;">Jumlah Lampiran</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['jumlah_lampiran']); ?>" readonly style="width:100%;margin-bottom:0.5em;">
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
</script>

</body>
</html>
