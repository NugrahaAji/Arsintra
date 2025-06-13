<?php
require_once '../config.php';
require_once '../config/session.php';

requireLogin();

$stmt = $conn->prepare("
    SELECT sm.*, u.nama_lengkap as created_by_name, 'masuk' as tipe, sm.tanggal_masuk as tanggal_arsip 
    FROM surat_masuk sm 
    LEFT JOIN users u ON sm.created_by = u.id 
    WHERE sm.status = 'selesai'
");
$stmt->execute();
$surat_masuk = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("
    SELECT sk.*, u.nama_lengkap as created_by_name, 'keluar' as tipe, sk.tanggal_keluar as tanggal_arsip 
    FROM surat_keluar sk 
    LEFT JOIN users u ON sk.created_by = u.id
");
$stmt->execute();
$surat_keluar = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

date_default_timezone_set('Asia/Jakarta');
$arsip = array_merge($surat_masuk, $surat_keluar);
usort($arsip, function($a, $b) {
    return strtotime($b['tanggal_arsip']) - strtotime($a['tanggal_arsip']);
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Arsip - Arsintra</title>
  <link rel="stylesheet" href="../css/style.css" />
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
        <a href="./surat-keluar.php" class="sidebar-item ">
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
        <a href="./arsip.php" class="sidebar-item active">
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
    <h2>Arsip Surat</h2>
    <div style="margin-bottom:24px;display:flex;gap:12px;">
        <button class="arsip-filter-btn" data-filter="all" style="padding:6px 18px;border-radius:6px;border:1px solid #d1d5db;background:#fff;cursor:pointer;font-weight:500;">Semua</button>
        <button class="arsip-filter-btn" data-filter="masuk" style="padding:6px 18px;border-radius:6px;border:1px solid #2563eb;background:#2563eb;color:#fff;cursor:pointer;font-weight:500;">Surat Masuk</button>
        <button class="arsip-filter-btn" data-filter="keluar" style="padding:6px 18px;border-radius:6px;border:1px solid #059669;background:#059669;color:#fff;cursor:pointer;font-weight:500;">Surat Keluar</button>
    </div>
    <div class="grid-container">
        <?php foreach ($arsip as $surat): ?>
        <div class="card arsip-card" data-tipe="<?php echo $surat['tipe']; ?>">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;padding:2px 10px;border-radius:12px;
                    <?php if($surat['tipe']==='masuk'){echo 'background:#2563eb;color:#fff;';}else{echo 'background:#059669;color:#fff;';} ?>
                ">
                    <?php echo $surat['tipe']==='masuk'?'Surat Masuk':'Surat Keluar'; ?>
                </span>
            </div>
            <h3 style="font-weight:600;min-height:40px;display:flex;align-items:center;gap:10px;">
                <?php echo htmlspecialchars($surat['nama_surat']); ?>
            </h3>
            <p style="color:#666;font-size:15px;margin-bottom:10px;">
                <?php echo date('d F Y', strtotime($surat['tanggal_arsip'])); ?>
            </p>
            <?php
            $file_path = !empty($surat['file_path']) ? '../' . $surat['file_path'] : '';
            $img_src = !empty($surat['file_path']) ? $surat['file_path'] : '';
            $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            $is_image = in_array($file_ext, ['jpg','jpeg','png']);
            ?>
            <?php if ($is_image && file_exists($file_path)): ?>
                <img src="<?php echo htmlspecialchars($img_src); ?>" alt="Scan Surat" class="surat-image" style="width:100%;height:140px;object-fit:cover;border-radius:6px;margin-bottom:1rem;" />
            <?php else: ?>
                <img src="../asset/image/surat-preview.png" alt="Surat" class="surat-image" style="width:100%;height:140px;object-fit:cover;border-radius:6px;margin-bottom:1rem;" />
            <?php endif; ?>
            <div class="button-group-arsip" style="display:flex;gap:16px;align-items:center;">
                <a href="download-surat.php?id=<?php echo $surat['id']; ?>&type=<?php echo $surat['tipe']; ?>" style="font-weight: 400; gap: 10px; display: flex; align-items: center;" class="btn btn-primary" title="Download Scan Surat">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4m4-5l5 5 5-5m-5 5V3"></path>
                    </svg>Simpan
                </a>
                <a href="<?php echo $surat['tipe'] === 'masuk' ? 'detail-surat-masuk.php?id=' . $surat['id'] : 'detail-surat-keluar.php?id=' . $surat['id']; ?>" style="color: #da0700; gap: 10px; display: flex; align-items: center;" class="btn btn-secondary">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>Detail
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <script>
  
    const filterBtns = document.querySelectorAll('.arsip-filter-btn');
    const cards = document.querySelectorAll('.arsip-card');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            cards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-tipe') === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
            filterBtns.forEach(b=>b.style.background='#fff');
            filterBtns.forEach(b=>b.style.color='');
            if(filter==='masuk'){this.style.background='#2563eb';this.style.color='#fff';}
            else if(filter==='keluar'){this.style.background='#059669';this.style.color='#fff';}
        });
    });
    </script>
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
