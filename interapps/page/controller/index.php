<?php
/**
 * Halaman Manajemen Data Controller Starlink
 * Konsep: Unified Clean UI - Menyesuaikan dengan style Add/Edit
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./function/nocodb.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ==========================================================================
   KONFIGURASI DATA & PAGINATION
   ========================================================================== */
$limit  = 50; 
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

/* ==========================================================================
   LOGIKA PENCARIAN
   ========================================================================== */
$search = $_GET['q'] ?? '';
$where  = '';

if ($search !== '') {
    $keyword = urlencode($search);
    $where = "&where=(NamaController,like,%25{$keyword}%25)";
}

$response = nocodb_get(
    "/tables/mtvbg7xww4vqwj7/records?"
    . "limit={$limit}&offset={$offset}{$where}&sort=-CreatedAt"
);

$controllers = $response['list'] ?? [];
$totalData   = $response['pageInfo']['totalRows'] ?? 0; 
$totalPage   = ceil($totalData / $limit);
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-color: #4361ee;
        --bg-body: #f4f7fe;
        --text-dark: #2b3674;
        --text-muted: #a3aed0;
        --card-radius: 20px;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
    }

    .main-container {
        padding: 2rem;
        max-width: 1200px;
        margin: auto;
    }

    /* Header Styling */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-header h2 {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.75rem;
        margin-bottom: 0;
    }

    /* Card Styling - Menyesuaikan Add/Edit */
    .custom-card {
        background: white;
        border: none;
        border-radius: var(--card-radius);
        box-shadow: 0px 18px 40px 0px rgba(112, 144, 176, 0.12);
        padding: 1.5rem;
    }

    /* Search Input Group */
    .search-box {
        background-color: var(--bg-body);
        border: none;
        border-radius: 12px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        color: var(--text-dark);
        width: 100%;
        transition: 0.3s;
    }

    .search-box:focus {
        background-color: #fff;
        box-shadow: 0 0 0 2px var(--primary-color);
        outline: none;
    }

    /* Table Styling */
    .table-responsive {
        margin-top: 1rem;
    }

    .table thead th {
        background: transparent;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f4f7fe;
        color: var(--text-dark);
        font-weight: 500;
    }

    .unit-name {
        font-weight: 700;
        color: var(--text-dark);
        display: block;
    }

    .unit-sub {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    /* Badge Style */
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-active { background: #e6f9f0; color: #05cd99; }
    .badge-inactive { background: #fef5f5; color: #ee5d50; }

    /* Action Buttons */
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 0.2s;
        border: none;
        margin: 0 2px;
        text-decoration: none;
    }

    .btn-view { background: #f4f7fe; color: #4361ee; }
    .btn-edit { background: #f4f7fe; color: #ffb547; }
    .btn-delete { background: #fff1f0; color: #ee5d50; }

    .btn-action:hover {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }

    .btn-primary-custom {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 15px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: 0.3s;
        box-shadow: 0px 4px 12px 0px rgba(67, 97, 238, 0.3);
    }

    .btn-primary-custom:hover {
        background: #3652d1;
        box-shadow: 0px 6px 15px 0px rgba(67, 97, 238, 0.4);
        color: white;
    }
</style>

<div class="main-container">
    <div class="page-header">
        <div>
            <h2>Data Controller</h2>
            <!-- <p class="text-muted small mb-0">Kelola dan pantau seluruh infrastruktur Starlink Anda.</p> -->
        </div>
        <a href="index.php?halaman=tambah_controller" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg me-1"></i> Tambah Perangkat
        </a>
    </div>

    <div class="custom-card mb-4">
        <form method="get" class="row align-items-center g-3">
            <input type="hidden" name="halaman" value="controller">
            <div class="col-md-10">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute text-muted" style="left: 15px; top: 12px;"></i>
                    <input type="text" name="q" class="search-box ps-5" placeholder="Cari unit atau nama pemilik..." value="<?= htmlspecialchars($search); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom w-100 shadow-none" style="padding: 0.6rem;">Cari</button>
            </div>
        </form>
    </div>

    <div class="custom-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Daftar Unit</h5>
            <span class="badge bg-light text-dark fw-bold rounded-pill px-3">Total: <?= $totalData ?></span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="ps-0">Informasi Unit</th>
                        <th>Lokasi</th>
                        <th>Pemilik Akun</th>
                        <th>Status</th>
                        <th class="text-end pe-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($controllers)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data unit tersimpan.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($controllers as $row): ?>
                        <?php $isAktif = ($row['StatusAktif'] ?? '') === 'Aktif'; ?>
                        <tr>
                            <td class="ps-0">
                                <span class="unit-name"><?= htmlspecialchars($row['NamaController'] ?? '-'); ?></span>
                                <span class="unit-sub"><?= htmlspecialchars($row['CodeController'] ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <div class="small"><i class="bi bi-geo-alt me-1 text-primary"></i><?= htmlspecialchars($row['LokasiPemasangan'] ?? '-'); ?></div>
                            </td>
                            <td>
                                <div class="fw-bold small"><?= htmlspecialchars($row['NamaAkun'] ?? '-'); ?></div>
                                <div class="unit-sub" style="font-size: 0.7rem;"><?= htmlspecialchars($row['EmailAkun'] ?? '-'); ?></div>
                            </td>
                            <td>
                                <span class="badge-custom <?= $isAktif ? 'badge-active' : 'badge-inactive' ?>">
                                    <i class="bi bi-record-fill"></i> <?= $isAktif ? 'Active' : 'Offline' ?>
                                </span>
                            </td>
                            <td class="text-end pe-0">
                                <a href="index.php?halaman=controller/read&id=<?= $row['Id']; ?>" class="btn-action btn-view" title="Detail"><i class="bi bi-eye-fill"></i></a>
                                <a href="index.php?halaman=edit_controller&id=<?= $row['Id']; ?>" class="btn-action btn-edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <a href="index.php?halaman=hapus_controller&id=<?= $row['Id']; ?>" onclick="return confirm('Hapus unit ini?')" class="btn-action btn-delete" title="Hapus"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPage > 1): ?>
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="small text-muted">Halaman <b><?= $page ?></b> dari <b><?= $totalPage ?></b></div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link rounded-pill px-3 border-0 me-2 bg-light" href="index.php?halaman=controller&page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">Prev</a>
                    </li>
                    <li class="page-item <?= $page >= $totalPage ? 'disabled' : '' ?>">
                        <a class="page-link rounded-pill px-3 border-0 bg-light" href="index.php?halaman=controller&page=<?= $page + 1 ?>&q=<?= urlencode($search) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>