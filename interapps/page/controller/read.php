<?php
require_once "./function/nocodb.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID tidak valid!</div>";
    exit;
}

$row = nocodb_get("/tables/mtvbg7xww4vqwj7/records/{$id}");

if (!$row) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan!</div>";
    exit;
}

$statusAktif = $row['StatusAktif'] ?? '-';
$badgeColor = ($statusAktif === 'Aktif') ? 'bg-success' : 'bg-secondary';
?>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card overflow-hidden mb-4 shadow-sm border-0" style="border-radius: 15px;">
                <div class="position-relative" style="height: 250px; background: url('https://images.unsplash.com/photo-1621932953912-0b6d8bb2c54e?q=80&w=2000&auto=format&fit=crop') center/cover no-repeat;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <span class="badge <?= $badgeColor ?> mb-2 px-3"><?= htmlspecialchars($statusAktif) ?></span>
                                <h2 class="text-white mb-1"><?= htmlspecialchars($row['NamaController'] ?? 'Unit Starlink'); ?></h2>
                                <p class="text-white-50 mb-0"><i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($row['LokasiPemasangan'] ?? '-'); ?></p>
                            </div>
                            <div class="d-none d-md-block text-end">
                                <p class="text-white-50 small mb-0">Paket Layanan</p>
                                <h4 class="text-white"><?= htmlspecialchars($row['PaketLayanan'] ?? '-'); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Detail Perangkat</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Nama Akun Pemilik</label>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="bg-light-primary p-2 rounded me-3"><i class="bi bi-person-fill text-primary"></i></div>
                                        <h6 class="mb-0"><?= htmlspecialchars($row['NamaAkun'] ?? '-'); ?></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Email Terdaftar</label>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="bg-light-info p-2 rounded me-3"><i class="bi bi-envelope-fill text-info"></i></div>
                                        <h6 class="mb-0"><?= htmlspecialchars($row['EmailAkun'] ?? '-'); ?></h6>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="text-muted small d-block mb-2">Catatan Perangkat</label>
                                    <div class="p-3 rounded border-start border-4 border-primary bg-light">
                                        <span class="fst-italic text-secondary">"<?= nl2br(htmlspecialchars($row['Catatan'] ?? 'Tidak ada catatan tambahan untuk unit ini.')); ?>"</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="card h-100 shadow-sm border-primary border-top border-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Akses Manajemen</h5>
                            
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Login Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-at text-muted"></i></span>
                                    <input type="text" class="form-control bg-white border-start-0 ps-0" value="<?= htmlspecialchars($row['UsernameEmail'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small mb-1">Password Akses</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-key text-muted"></i></span>
                                    <input type="password" id="passInput" class="form-control bg-white border-start-0 ps-0" value="<?= htmlspecialchars($row['PasswordEmail'] ?? ''); ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i id="toggleIcon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-auto">
                                <a href="index.php?halaman=edit_controller&id=<?= $id ?>" class="btn btn-primary shadow">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Data
                                </a>
                                <a href="index.php?halaman=controller" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function togglePassword() {
    const passInput = document.getElementById('passInput');
    const toggleIcon = document.getElementById('toggleIcon');
    if (passInput.type === 'password') {
        passInput.type = 'text';
        toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        passInput.type = 'password';
        toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>