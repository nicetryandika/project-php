<?php
// 1. Perbaikan Session: Hanya jalankan jika belum ada session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./function/nocodb.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* ===============================
   CONFIG PAGINATION
================================ */
$limit  = 50; 
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

/* ===============================
   SEARCH FILTER
================================ */
$search = $_GET['q'] ?? '';
$where  = '';

if ($search !== '') {
    $keyword = urlencode($search);
    // Format NocoDB v2: (NamaKolom,like,%keyword%)
    $where = "&where=(NamaController,like,%25{$keyword}%25)";
}

/* ===============================
   FETCH DATA FROM NOCODB
================================ */
$response = nocodb_get(
    "/tables/mtvbg7xww4vqwj7/records?"
    . "limit={$limit}&offset={$offset}{$where}"
);

// 2. Perbaikan Key Response NocoDB v2
$controllers = $response['list'] ?? [];
$totalData   = $response['pageInfo']['totalRows'] ?? 0; // Ubah dari 'count' ke ini
$totalPage   = ceil($totalData / $limit);

// DEBUG (Opsional, bisa dihapus jika sudah lancar)

// echo "DEBUG: Total Data found: " . $totalData; 

?>

<div class="page-heading">
    <h3>Data Controller Starlink</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">

            <!-- SEARCH -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="get" class="row g-2 align-items-center">
                        <input type="hidden" name="halaman" value="controller">
                        
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" 
                                placeholder="Cari nama controller..." 
                                value="<?= htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-auto">
                            <a href="index.php?halaman=controller" class="btn btn-light">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List Controller</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">No</th>
                                    <th>Nama Controller</th>
                                    <th>Nama Akun</th>
                                    <th>Email Akun</th>
                                    <th>Status Aktif</th>
                                    <th class="text-center" width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($controllers)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($controllers as $i => $row): ?>
                                    <tr>
                                        <td><?= $offset + $i + 1; ?></td>
                                        <td><?= htmlspecialchars($row['NamaController'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['NamaAkun'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['EmailAkun'] ?? '-'); ?></td>
                                        <td>
                                            <?php if (($row['StatusAktif'] ?? '') === 'Aktif'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="index.php?halaman=controller/read&id=<?= $row['Id']; ?>"
                                               class="btn btn-sm btn-info"
                                               title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="index.php?halaman=controller/edit&id=<?= $row['Id']; ?>"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="index.php?halaman=controller/delete&id=<?= $row['Id']; ?>"
                                               onclick="return confirm('Hapus data ini?')"
                                               class="btn btn-sm btn-danger"
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- PAGINATION -->
                    <?php if ($totalPage > 1): ?>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-end">

                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" 
                                href="index.php?halaman=controller&page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">
                                &laquo;
                                </a>
                            </li>

                            <?php for ($p = 1; $p <= $totalPage; $p++): ?>
                                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                    <a class="page-link" 
                                    href="index.php?halaman=controller&page=<?= $p ?>&q=<?= urlencode($search) ?>">
                                        <?= $p ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $page >= $totalPage ? 'disabled' : '' ?>">
                                <a class="page-link" 
                                href="index.php?halaman=controller&page=<?= $page + 1 ?>&q=<?= urlencode($search) ?>">
                                &raquo;
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </section>
</div>