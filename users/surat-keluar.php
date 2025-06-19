<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

$total_query = "SELECT COUNT(*) as total FROM surat_keluar";
if ($search) {
    $total_query .= " WHERE nomor_surat LIKE ? OR nama_surat LIKE ? OR tujuan_surat LIKE ?";
}
$stmt = $conn->prepare($total_query);
if ($search) {
    $search_param = "%$search%";
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
}
$stmt->execute();
$total_records = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_records / $per_page);

$query = "SELECT * FROM surat_keluar";
if ($search) {
    $query .= " WHERE nomor_surat LIKE ? OR nama_surat LIKE ? OR tujuan_surat LIKE ?";
}
$query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
if ($search) {
    $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $per_page, $offset);
} else {
    $stmt->bind_param("ii", $per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar - Arsintra</title>
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

            <main class="page-content">
                <div class="page-header">
                    <h1>Surat keluar</h1>
                    <a href="./tambah-surat-keluar.php" class="btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2"/></svg>
                        Tambah
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success" style="margin-bottom:20px; color:#1a7f37; background:#d4f8e8; border:1px solid #1a7f37; border-radius:8px; padding:12px 20px; font-weight:500;">
                        <svg class="icon" viewBox="0 0 24 24" style="width:20px; height:20px; margin-right:8px; vertical-align:middle;">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php
                        $pesan = $_GET['success'] ?? '';
                        $successMessage = '';
                        if ($pesan === '1') {
                            echo "Surat keluar berhasil ditambahkan!";
                        } elseif ($pesan === '2') {
                            echo  "Surat keluar berhasil diperbarui!";
                        } elseif ($pesan === '3') {
                            echo "Surat keluar berhasil dihapus!";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error" style="margin-bottom:20px; color:#dc2626; background:#fee2e2; border:1px solid #dc2626; border-radius:8px; padding:12px 20px; font-weight:500;">
                        <svg class="icon" viewBox="0 0 24 24" style="width:20px; height:20px; margin-right:8px; vertical-align:middle;">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Surat</th>
                                    <th>Nama Surat</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Tujuan</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $offset + 1;
                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nomor_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_surat']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tanggal_keluar'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['tujuan_surat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="detail-surat-keluar.php?id=<?php echo $row['id']; ?>" class="btn-detail">Detail</a>
                                            <a href="download-surat.php?id=<?php echo $row['id']; ?>&type=keluar" class="btn-icon" title="Download">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16.004V17a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1M12 4.5v11m3.5-3.5L12 15.5L8.5 12"/></svg>
                                            </a>
                                            <a href="./edit-surat-keluar.php?id=<?php echo $row['id']; ?>" class="btn-icon" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 21h16M5.666 13.187A2.28 2.28 0 0 0 5 14.797V18h3.223c.604 0 1.183-.24 1.61-.668l9.5-9.505a2.28 2.28 0 0 0 0-3.22l-.938-.94a2.277 2.277 0 0 0-3.222.001z"/></svg>
                                            </a>
                                            <a href="hapus-surat-keluar.php?id=<?php echo $row['id']; ?>" class="btn-icon" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#da0700" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="m14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.088 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">&laquo; Sebelumnya</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>" class="page-link">Selanjutnya &raquo;</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. LOGIKA UNTUK DROPDOWN PROFIL ---
    const profileButton = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');

    if (profileButton && profileMenu) {
        profileButton.addEventListener('click', function(e) {
            // Mencegah event 'click' menyebar ke elemen lain
            e.stopPropagation();
            // Menampilkan atau menyembunyikan menu
            profileMenu.classList.toggle('show');
        });

        // Menutup menu jika user klik di luar area dropdown
        document.addEventListener('click', function(e) {
            if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
            }
        });
    }

    // --- 2. LOGIKA UMUM UNTUK SEMUA MODAL (DELETE & LOGOUT) ---
    const deleteModal = document.getElementById('deleteModal');
    const logoutModal = document.getElementById('logoutModal');

    // Fungsi umum untuk menutup SEMUA modal yang sedang aktif
    function closeModal() {
        if (deleteModal) deleteModal.classList.add('hidden');
        if (logoutModal) logoutModal.classList.add('hidden');
    }

    // Tambahkan event listener ke semua tombol "Batal" di dalam modal
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Tambahkan event listener untuk menutup modal jika klik di area latar belakang
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    });

    // --- 3. LOGIKA UNTUK TOMBOL LOGOUT ---
    const logoutBtn = document.querySelector('.sidebar-item[href="./logout.php"]');
    if (logoutBtn && logoutModal) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah pindah halaman langsung
            logoutModal.classList.remove('hidden'); // Tampilkan modal logout
        });
    }
});


// --- 4. FUNGSI BARU YANG REUSABLE UNTUK KONFIRMASI HAPUS ---
// Fungsi ini dibuat di luar DOMContentLoaded agar bisa diakses oleh 'onclick' di HTML
function confirmDelete(id, type) {
    const modal = document.getElementById('deleteModal');
    const confirmBtn = document.getElementById('confirmDelete');
    
    if (!modal || !confirmBtn) {
        console.error('Modal atau tombol konfirmasi hapus tidak ditemukan!');
        return;
    }

    // Set URL hapus secara dinamis berdasarkan tipe
    confirmBtn.href = `./hapus-${type}.php?id=${id}`;
    
    // Tampilkan modal konfirmasi hapus
    modal.classList.remove('hidden');
}
</script>
</body>
</html>
