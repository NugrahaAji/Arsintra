<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;

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
                            <a href="edit-akun-pengguna.php?id=<?php echo $_SESSION['admin_id']; ?>" class="dropdown-item">
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
                <div style="padding:32px 24px 24px 24px;border-radius:18px;box-shadow:0 2px 16px #0001;max-width:1100px;margin:auto;display:flex;flex-direction:column;gap:32px;">
                     <div>
                        <div class="block" style="display:flex; align-items: start;">
                            <h2 style="display:inline-block; margin-right:10px;"><?php echo htmlspecialchars($surat['nama_surat']); ?></h2>
                            <?php
                            $status = $surat['status'];
                            $badge = '';
                            $label = '';
                            if ($status === 'menunggu') {
                                $badge = 'style="background:#fff6e0;color:#e6a700;border:1px solid #e6a700;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;vertical-align:middle;"'; // Added vertical-align
                                $label = '<span style="font-size:18px;">&#9888;</span> Menunggu Tindakan';
                            } elseif ($status === 'selesai') {
                                $badge = 'style="background:#d4f8e8;color:#1a7f37;border:1px solid #1a7f37;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;vertical-align:middle;"';
                                $label = '<span style="font-size:18px;">&#10003;</span> Selesai Arsip';
                            } elseif ($status === 'ditolak') {
                                $badge = 'style="background:#ffe0e0;color:#d32f2f;border:1px solid #d32f2f;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;vertical-align:middle;"';
                                $label = '<span style="font-size:18px;">&#10005;</span> Ditolak';
                            }
                            ?>
                            <span <?php echo $badge; ?>><?php echo $label; ?></span>
                        </div>
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
                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-group">
                                <label >No Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['nomor_surat']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Asal Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['asal_surat']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Nama Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['nama_surat']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Kategori</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['kategori']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Tanggal Surat</label>
                                <input type="text" value="<?php echo date('d - m - Y', strtotime($surat['tanggal_surat'])); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Tanggal Terima</label>
                                <input type="text" value="<?php echo date('d - m - Y', strtotime($surat['tanggal_terima'])); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Tanggal Masuk</label>
                                <input type="text" value="<?php echo date('d - m - Y', strtotime($surat['tanggal_masuk'])); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Petugas Arsip</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['petugas_arsip']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Pengirim</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['pengirim']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Jumlah Lampiran</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['jumlah_lampiran']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Perihal</label>
                                <textarea readonly style="width:100%;min-height:60px;resize:vertical;"><?php echo htmlspecialchars($surat['perihal']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label >Deskripsi Surat</label>
                                <textarea readonly style="width:100%;min-height:60px;resize:vertical;"><?php echo htmlspecialchars($surat['deskripsi_surat']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Dibuat Oleh</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['created_by_name']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Tanggal Dibuat</label>
                                <input type="text" value="<?php echo date('d - m - Y H:i', strtotime($surat['created_at'])); ?>" readonly>
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
</script>

</body>
</html>
