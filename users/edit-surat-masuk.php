<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$error = '';
$success = '';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM surat_masuk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$surat = $result->fetch_assoc();

if (!$surat) {
    header('Location: surat-masuk.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_surat = $_POST['nomor_surat'] ?? '';
    $asal_surat = $_POST['asal_surat'] ?? '';
    $nama_surat = $_POST['nama_surat'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? '';
    $petugas_arsip = $_POST['petugas_arsip'] ?? '';
    $jumlah_lampiran = $_POST['jumlah_lampiran'] ?? '';
    $deskripsi_surat = $_POST['deskripsi_surat'] ?? '';
    $status = $_POST['status'] ?? 'menunggu';
    $alasan_ditolak = $_POST['alasan_ditolak'] ?? '';

    // Jika status ditolak, gunakan alasan_ditolak sebagai deskripsi_surat
    if ($status === 'ditolak' && !empty($alasan_ditolak)) {
        $deskripsi_surat = $alasan_ditolak;
    }

    // Handle file upload
    $file_path = $surat['file_path'];
    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] === UPLOAD_ERR_OK) {
        
        $upload_dir = '../uploads/surat_masuk/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Cek apakah direktori bisa ditulisi (writable)
        if (!is_writable($upload_dir)) {
            $error = "Error: Direktori upload tidak bisa ditulisi. Periksa izin folder (permissions).";
        } else {
            // Hapus file lama jika ada
            if ($file_path && file_exists('../' . $file_path)) {
                unlink('../' . $file_path);
            }

            $file_name = time() . '_' . basename($_FILES['file_surat']['name']);
            $target_path = $upload_dir . $file_name;

            // Pindahkan file yang baru diupload
            if (move_uploaded_file($_FILES['file_surat']['tmp_name'], $target_path)) {
                $file_path = 'uploads/surat_masuk/' . $file_name; // Update path dengan file baru
                $success = "File baru berhasil diupload."; // Pesan sukses sementara
            } else {
                $error = "Error: Gagal memindahkan file yang diupload. Kemungkinan masalah izin folder.";
            }
        }
    } elseif (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Menangkap error lain dari proses upload (misal: file terlalu besar)
        switch ($_FILES['file_surat']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error = "Error: Ukuran file melebihi batas upload server (upload_max_filesize).";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error = "Error: Ukuran file melebihi batas yang ditentukan di form.";
                break;
            default:
                $error = "Error upload file yang tidak diketahui.";
                break;
        }
    }

    // Validasi input
    $semua_valid = true;
    if (empty($nomor_surat) || empty($asal_surat) || empty($nama_surat) || empty($kategori) || empty($tanggal_masuk) || empty($petugas_arsip) || empty($jumlah_lampiran)) {
        $semua_valid = false;
    }

    // Deskripsi hanya wajib jika status bukan 'ditolak'
    if ($status !== 'ditolak' && empty($deskripsi_surat)) {
        $semua_valid = false;
    }

    // Alasan ditolak hanya wajib jika status 'ditolak'
    if ($status === 'ditolak' && empty($alasan_ditolak)) {
        $semua_valid = false;
    }

    if (!$semua_valid) { // Jika ada yang tidak valid
        $error = "Semua field dengan tanda * harus diisi";
    } else {
        // Lanjutkan dengan proses UPDATE ke database
        $stmt = $conn->prepare("UPDATE surat_masuk SET nomor_surat = ?, asal_surat = ?, nama_surat = ?, kategori = ?, tanggal_masuk = ?, petugas_arsip = ?, jumlah_lampiran = ?, deskripsi_surat = ?, file_path = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssi", $nomor_surat, $asal_surat, $nama_surat, $kategori, $tanggal_masuk, $petugas_arsip, $jumlah_lampiran, $deskripsi_surat, $file_path, $status, $id);

        if ($stmt->execute()) {
            $success = "Surat masuk berhasil diperbarui";
            // Refresh surat data
            $stmt = $conn->prepare("SELECT * FROM surat_masuk WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $surat = $result->fetch_assoc();
        } else {
            $error = "Gagal memperbarui surat masuk";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Surat Masuk - Arsintra</title>
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
                    <h1>Edit Surat Masuk</h1>
                    <div class="header-actions">
                        <a href="./surat-masuk.php" class="btn-back">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M19 12H5m7-7l-7 7 7 7"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>


                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="form">
                <div class="form-container-page">
                    <?php if ($success): ?>
                        <div class="alert alert-success" style="margin-bottom:20px; color:#1a7f37; background:#d4f8e8; border:1px solid #1a7f37; border-radius:8px; padding:12px 20px; font-weight:500;">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger" style="margin-bottom:20px; color:#d32f2f; background:#ffe0e0; border:1px solid #d32f2f; border-radius:8px; padding:12px 20px; font-weight:500;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nomor_surat">No Surat*</label>
                            <input type="text" id="nomor_surat" name="nomor_surat" value="<?php echo htmlspecialchars($surat['nomor_surat']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="asal_surat">Asal Surat *</label>
                            <input type="text" id="asal_surat" name="asal_surat" value="<?php echo htmlspecialchars($surat['asal_surat']); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_surat">Nama Surat *</label>
                            <input type="text" id="nama_surat" name="nama_surat" value="<?php echo htmlspecialchars($surat['nama_surat']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori *</label>
                            <input type="text" id="kategori" name="kategori" value="<?php echo htmlspecialchars($surat['kategori']); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk *</label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo htmlspecialchars($surat['tanggal_masuk']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="petugas_arsip">Petugas Arsip *</label>
                            <input type="text" id="petugas_arsip" name="petugas_arsip" value="<?php echo htmlspecialchars($surat['petugas_arsip']); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jumlah_lampiran">Jumlah Lampiran *</label>
                            <input type="text" id="jumlah_lampiran" name="jumlah_lampiran" value="<?php echo htmlspecialchars($surat['jumlah_lampiran']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="file_surat">Scan Surat*</label>
                            <?php if ($surat['file_path']): ?>
                                <p>File saat ini: <a href="../<?php echo htmlspecialchars($surat['file_path']); ?>" target="_blank">Lihat File</a></p>
                            <?php endif; ?>
                            <input type="file" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.csv,.png,.jpg">
                            <span class="file-format-note">format image (pdf,doc,docx,csv,png,jpg)</span>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="deskripsi_surat">Deskripsi Surat *</label>
                        <textarea id="deskripsi_surat" name="deskripsi_surat" required><?php echo htmlspecialchars($surat['deskripsi_surat']); ?></textarea>
                    </div>
                    <div class="form-group full-width" id="alasanDitolakGroup" style="display:<?php echo ($surat['status']==='ditolak') ? 'block' : 'none'; ?>;">
                        <label for="alasan_ditolak">Alasan Penolakan *</label>
                        <textarea id="alasan_ditolak" name="alasan_ditolak" rows="3"><?php echo ($surat['status']==='ditolak') ? htmlspecialchars($surat['deskripsi_surat']) : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" style="height:50px; font-size:16px; border: 1px solid #d1d5db; padding: 0.75rem; border-radius: 0.375rem;">
                            <option value="menunggu" <?php echo $surat['status'] === 'menunggu' ? 'selected' : ''; ?>>Menunggu Tindakan</option>
                            <option value="selesai" <?php echo $surat['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai Arsip</option>
                            <option value="ditolak" <?php echo $surat['status'] === 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="button-group" style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn-save   ">Simpan</button>
                    </div>
                </div>
                </form>
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
const statusSelect = document.getElementById('status');
const alasanGroup = document.getElementById('alasanDitolakGroup');
statusSelect.addEventListener('change', function() {
    if (this.value === 'ditolak') {
        alasanGroup.style.display = 'block';
        document.getElementById('alasan_ditolak').required = true;
    } else {
        alasanGroup.style.display = 'none';
        document.getElementById('alasan_ditolak').required = false;
    }
});
</script>
</body>
</html>