<?php
/**
 * Dashboard Page - Starlink Monitoring System
 * Mengambil ringkasan data operasional secara real-time dari NocoDB
 */

require_once "./function/nocodb.php";

// 1. Ambil data dari NocoDB (Limit besar untuk kalkulasi statistik)
$response = nocodb_get("/tables/mtvbg7xww4vqwj7/records?limit=1000");
$allData = $response['list'] ?? [];

// 2. Inisialisasi Variabel Statistik
$totalUnit    = count($allData);
$unitAktif    = 0;
$unitNonaktif = 0;
$paketStats   = [];

// 3. Looping Data untuk Kalkulasi
foreach ($allData as $row) {
    // Hitung Berdasarkan Status
    if (strtolower($row['StatusAktif'] ?? '') === 'aktif') {
        $unitAktif++;
    } else {
        $unitNonaktif++;
    }

    // Hitung Distribusi Paket Layanan
    $paket = $row['PaketLayanan'] ?? 'Standard';
    $paketStats[$paket] = ($paketStats[$paket] ?? 0) + 1;
}
?>

<div class="page-heading mb-4">
    <div class="d-flex align-items-center">
        <div class="avatar avatar-xl bg-primary-subtle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 12px;">
            <i class="bi bi-speedometer2 text-primary fs-3"></i>
        </div>
        
        <div>
            <h3 class="fw-bold mb-0" style="letter-spacing: -0.5px;">
                Dashboard <span class="text-primary">InterApps</span>
            </h3>
            <p class="text-muted mb-0 opacity-75" style="font-size: 0.95rem;">
                Pantau performa <span class="fw-semibold">Starlink</span> & manajemen akun dalam satu pintu.
            </p>
        </div>
    </div>
</div>

<div class="page-content mt-4">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon-new blue">
                                    <i class="bi bi-hdd-network"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted font-semibold small mb-1">TOTAL UNIT</h6>
                                    <h4 class="font-extrabold mb-0"><?= $totalUnit ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon-new green">
                                    <i class="bi bi-broadcast-pin"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted font-semibold small mb-1">AKTIF</h6>
                                    <h4 class="font-extrabold mb-0 text-success"><?= $unitAktif ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon-new red">
                                    <i class="bi bi-pigeon"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted font-semibold small mb-1">OFFLINE</h6>
                                    <h4 class="font-extrabold mb-0 text-danger"><?= $unitNonaktif ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon-new purple">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted font-semibold small mb-1">AVAILABILITY</h6>
                                    <h4 class="font-extrabold mb-0">
                                        <?= ($totalUnit > 0) ? round(($unitAktif / $totalUnit) * 100, 1) : 0 ?>%
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h4 class="card-title">Entry Terakhir Perangkat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Controller</th>
                                    <th>Akun Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $latestEntries = array_slice($allData, 0, 7); // Ambil 7 terbaru
                                foreach ($latestEntries as $unit): 
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($unit['NamaController'] ?? '-') ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($unit['PaketLayanan'] ?? '-') ?></small>
                                    </td>
                                    <td class="small text-muted"><?= htmlspecialchars($unit['EmailAkun'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge rounded-pill <?= (strtolower($unit['StatusAktif'] ?? '') === 'aktif') ? 'bg-light-success text-success' : 'bg-light-secondary text-secondary' ?>">
                                            <?= htmlspecialchars($unit['StatusAktif'] ?? 'Nonaktif') ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="index.php?halaman=controller" class="btn btn-sm btn-outline-primary px-4">Lihat Semua Data</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h4 class="card-title">Distribusi Paket Layanan</h4>
                </div>
                <div class="card-body">
                    <?php if(empty($paketStats)): ?>
                        <p class="text-center text-muted">Belum ada data paket.</p>
                    <?php else: ?>
                        <?php foreach ($paketStats as $label => $count): 
                             $percent = ($totalUnit > 0) ? ($count / $totalUnit) * 100 : 0;
                        ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold"><?= $label ?></span>
                                <span class="badge bg-primary rounded-pill"><?= $count ?> Unit</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="alert alert-light-info mt-4 border-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Data disinkronisasi secara otomatis dari NocoDB Cloud.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* CSS UNTUK WIDGET STATISTIK BARU */
.stats-icon-new {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
.stats-icon-new.blue { background-color: #e7f0ff; color: #435ebe; }
.stats-icon-new.green { background-color: #e8fadf; color: #198754; }
.stats-icon-new.red { background-color: #ffe5e5; color: #dc3545; }
.stats-icon-new.purple { background-color: #f3e8ff; color: #8250df; }

.bg-light-success { background-color: #e8fadf !important; }
.bg-light-primary { background-color: #e7f0ff !important; }
.bg-light-secondary { background-color: #f0f2f5 !important; }

.card-title {
    font-size: 1.1rem;
    font-weight: 700;
}
</style>