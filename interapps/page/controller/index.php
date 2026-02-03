<?php
require_once "./function/nocodb.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$data = nocodb_get(
    "/tables/mtvbg7xww4vqwj7/records?limit=100"
);

$controllers = $data['list'] ?? [];

// // DEBUG SEKALI SAJA
// echo '<pre>'; print_r($data); exit;

?>

<div class="page-heading">
    <h3>Data Controller Starlink</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">

            <!-- SEARCH
            <div class="card">
                <div class="card-body">
                    <form method="get" class="row g-2">
                        <div class="col-md-4">
                            <input type="text"
                                   name="q"
                                   class="form-control"
                                   placeholder="Cari nama controller..."
                                   value="<?= htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                        <div class="col-md-auto">
                            <a href="index.php" class="btn btn-light">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div> -->

            <!-- TABLE -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List Controller</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Controller</th>
                                    <th>Nama Akun</th>
                                    <th>Email Akun</th>
                                    <th>Status Aktif</th>
                                    <th class="text-center">Aksi</th>
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
                                        <td><?= $i + 1; ?></td>
                                        <td><?= htmlspecialchars($row['Nama Controller'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['Nama Akun'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['Email Akun'] ?? '-'); ?></td>
                                        <td>
                                            <?php if (($row['Status Aktif'] ?? '') === 'Aktif'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <!--  READ  -->
                                        <td class="text-center">
                                            <a href="index.php?halaman=controller/read&id=<?= $row['Id']; ?>"
                                            class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!--  EDIT  -->
                                            <a href="index.php?halaman=controller/edit&id=<?= $row['Id']; ?>"
                                            class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <!--  DELETE  -->
                                            <a href="index.php?halaman=controller/delete&id=<?= $row['Id']; ?>"
                                            onclick="return confirm('Hapus data ini?')"
                                            class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
