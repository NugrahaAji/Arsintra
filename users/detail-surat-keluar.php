<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM surat_keluar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();

if (!$surat) {
    header('Location: surat-keluar.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Keluar - Arsintra</title>
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
                <a href="./surat-masuk.php" class="sidebar-item">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Surat Masuk</span>
                </a>
                <a href="./surat-keluar.php" class="sidebar-item active">
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

            <main class="page-content">
                <div class="page-header">
                    <h1>Detail Surat Keluar</h1>
                    <div class="header-actions">
                        <a href="./surat-keluar.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="detail-container" >
                    <div class="detail-header" style="margin-top: 20px;">
                        <div>
                            <div class="block">
                                <h2 style="display:inline-block; margin-right:10px;" ><?php echo htmlspecialchars($surat['nama_surat']); ?></h2>
                                <?php
                                // Tampilkan status surat keluar dengan badge warna
                                $status = $surat['status'];
                                $badge = '';
                                $label = '';
                                if ($status === 'draft') {
                                    $badge = 'style="background:#fff6e0;color:#e6a700;border:1px solid #e6a700;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;margin-bottom:12px;"';
                                    $label = '<span style="font-size:18px;">&#9888;</span> Draft';
                                } elseif ($status === 'terkirim') {
                                    $badge = 'style="background:#d4f8e8;color:#1a7f37;border:1px solid #1a7f37;padding:2px 12px;border-radius:16px;display:inline-flex;align-items:center;gap:4px;margin-bottom:12px;"';
                                    $label = '<span style="font-size:18px;">&#10003;</span> Terkirim';
                                }
                                ?>
                                
                            </div>
                            <div class="block">
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
                                    <a href="../<?php echo htmlspecialchars($file_path); ?>" target="_blank" class="btn-save" style="margin-top:16px;display:inline-block;">Download File</a>
                                <?php else: ?>
                                    <div style="color:#888;font-style:italic;">Tidak ada file</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-group">
                                <label >No Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['nomor_surat']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Tanggal Keluar</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['tanggal_keluar']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Tujuan Surat</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['tujuan_surat']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Tanggal Keluar</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['di_keluarkan']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label >Kategori</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['kategori']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Deskripsi</label>
                                <input type="text" value="<?php echo htmlspecialchars($surat['deskripsi_surat']); ?>" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay hidden">
        <div class="modal-content">
            <h3 class="modal-confirm">Yakin ingin menghapus surat ini?</h3>
            <p>Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="modal-actions">
                <button id="cancelDelete" class="btn-cancel">Batal</button>
                <a href="#" id="confirmDelete" class="btn-delete">Hapus</a>
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
        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const confirmBtn = document.getElementById('confirmDelete');
            const cancelBtn = document.getElementById('cancelDelete');

            modal.classList.remove('hidden');
            confirmBtn.href = `./hapus-surat-keluar.php?id=${id}`;

            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
            }

            window.onclick = function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
