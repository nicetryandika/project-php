<?php
/**
 * Halaman Manajemen Data Controller Starlink
 * Fokus: List data, Pencarian, dan Navigasi Halaman
 */

// 1. Session Guard: Memastikan sesi aktif untuk keamanan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./function/nocodb.php";

// 2. Auth Check: Proteksi halaman agar hanya bisa diakses user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ==========================================================================
   KONFIGURASI DATA & PAGINATION
   ========================================================================== */
$limit  = 50; // Jumlah data per halaman
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

/* ==========================================================================
   LOGIKA PENCARIAN (FILTER)
   ========================================================================== */
$search = $_GET['q'] ?? '';
$where  = '';

if ($search !== '') {
    $keyword = urlencode($search);
    // Operator LIKE untuk mencari nama yang mirip di NocoDB v2
    $where = "&where=(NamaController,like,%25{$keyword}%25)";
}

/* ==========================================================================
   PROSES AMBIL DATA (READ) DARI NOCODB
   ========================================================================== */
$response = nocodb_get(
    "/tables/mtvbg7xww4vqwj7/records?"
    . "limit={$limit}&offset={$offset}{$where}&sort=-CreatedAt" // Mengurutkan dari yang terbaru
);

// Mapping hasil API ke dalam variabel lokal
$controllers = $response['list'] ?? [];
$totalData   = $response['pageInfo']['totalRows'] ?? 0; 
$totalPage   = ceil($totalData / $limit);
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Unit Controller</h3>
                <p class="text-subtitle text-muted">Kelola informasi perangkat dan akun Starlink di satu tempat.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first text-end">
                <a href="index.php?halaman=tambah_controller" class="btn btn-primary shadow-sm mt-2">
                    <i class="bi bi-plus-lg"></i> Tambah Unit Baru
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-content mt-3">
    <section class="section">
        
        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <form method="get" class="row g-2">
                    <input type="hidden" name="halaman" value="controller">
                    <div class="col-md-10">
                        <div class="form-group has-icon-left mb-0">
                            <div class="position-relative">
                                <input type="text" name="q" class="form-control" 
                                    placeholder="Cari Nama Controller..." 
                                    value="<?= htmlspecialchars($search); ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-search text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-outline-primary">Cari Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-0">List Controller Starlink</h4>
                <span class="text-muted small">Total: <strong><?= $totalData ?></strong> Record</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Informasi Controller</th>
                                <th>Pemilik Akun</th>
                                <th>Status Aktif</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($controllers)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-info-circle display-4 text-muted"></i>
                                    <p class="mt-2">Data tidak ditemukan.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($controllers as $i => $row): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $offset + $i + 1; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0 text-primary fw-bold"><?= htmlspecialchars($row['NamaController'] ?? '-'); ?></h6>
                                                <small class="text-muted"><i class="bi bi-hdd me-1"></i> <?= htmlspecialchars($row['PaketLayanan'] ?? 'Standard'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium"><?= htmlspecialchars($row['NamaAkun'] ?? '-'); ?></span>
                                            <small class="text-muted italic"><?= htmlspecialchars($row['EmailAkun'] ?? '-'); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (($row['StatusAktif'] ?? '') === 'Aktif'): ?>
                                            <span class="badge bg-light-success text-success border border-success px-3">
                                                <i class="bi bi-dot"></i> Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light-secondary text-secondary border px-3">
                                                <i class="bi bi-dot"></i> Nonaktif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="index.php?halaman=controller/read&id=<?= $row['Id']; ?>"
                                                class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="index.php?halaman=edit_controller&id=<?= $row['Id']; ?>"
                                                class="btn btn-sm btn-warning text-white" title="Edit Data">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="index.php?halaman=hapus_controller&id=<?= $row['Id']; ?>"
                                                onclick="return confirm('Hapus data controller ini?')"
                                                class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top py-3">
                <?php if ($totalPage > 1): ?>
                <nav>
                    <ul class="pagination pagination-primary justify-content-end mb-0">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="index.php?halaman=controller&page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">
                                <i class="bi bi-chevron-left small"></i>
                            </a>
                        </li>

                        <?php for ($p = 1; $p <= $totalPage; $p++): ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?halaman=controller&page=<?= $p ?>&q=<?= urlencode($search) ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $page >= $totalPage ? 'disabled' : '' ?>">
                            <a class="page-link" href="index.php?halaman=controller&page=<?= $page + 1 ?>&q=<?= urlencode($search) ?>">
                                <i class="bi bi-chevron-right small"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>