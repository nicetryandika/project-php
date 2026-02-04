<?php
// page/controller/edit.php

if (file_exists("function/nocodb.php")) {
    require_once "function/nocodb.php";
} elseif (file_exists("../../function/nocodb.php")) {
    require_once "../../function/nocodb.php";
}

$id = $_GET['id'] ?? null;
$tableId = "mtvbg7xww4vqwj7";

$data = [];
if ($id) {
    $data = nocodb_get("/tables/{$tableId}/records/{$id}");
}

if (empty($data) || isset($data['msg'])) {
    echo "<div class='alert alert-danger mx-4 mt-4'>Data tidak ditemukan! Kembali ke <a href='index.php?halaman=controller'>Daftar</a></div>";
    exit;
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="fw-bold text-dark">Modifikasi Unit</h3>
                <p class="text-subtitle text-muted">ID Perangkat: <span class="badge bg-light-primary text-primary">#<?= $id ?></span></p>
            </div>
        </div>
    </div>
</div>

<section class="section mt-4">
    <form action="page/controller/process_update.php" method="POST">
        <input type="hidden" name="Id" value="<?= $data['Id'] ?? '' ?>">

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon orange me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background-color: #ff9f43;">
                                <i class="bi bi-pencil-square text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Update Informasi Teknis</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Nama Controller</label>
                                <input type="text" class="form-control form-control-lg fs-6 border-warning" name="NamaController" 
                                       value="<?= htmlspecialchars($data['NamaController'] ?? '') ?>" required>
                                <small class="text-muted">Nama unik untuk identifikasi perangkat di lapangan.</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Paket Layanan</label>
                                <?php $paket = $data['PaketLayanan'] ?? ''; ?>
                                <select class="form-select" name="PaketLayanan">
                                    <option value="Standard" <?= $paket == 'Standard' ? 'selected' : '' ?>>Standard</option>
                                    <option value="Priority" <?= $paket == 'Priority' ? 'selected' : '' ?>>Priority</option>
                                    <option value="Mobile-Priority" <?= $paket == 'Mobile-Priority' ? 'selected' : '' ?>>Mobile Priority</option>
                                    <option value="Business" <?= $paket == 'Business' ? 'selected' : '' ?>>Business</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Operasional</label>
                                <?php $status = $data['StatusAktif'] ?? ''; ?>
                                <select class="form-select fw-bold <?= $status == 'Aktif' ? 'text-success' : 'text-danger' ?>" name="StatusAktif">
                                    <option value="Aktif" <?= $status == 'Aktif' ? 'selected' : '' ?>>● Aktif</option>
                                    <option value="Nonaktif" <?= $status == 'Nonaktif' ? 'selected' : '' ?>>○ Nonaktif</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Lokasi Pemasangan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" name="LokasiPemasangan" 
                                           value="<?= htmlspecialchars($data['LokasiPemasangan'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon blue me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background-color: #435ebe;">
                                <i class="bi bi-person-gear text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Pemilik & Kontak</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Pemilik Akun</label>
                                <input type="text" class="form-control" name="NamaAkun" 
                                       value="<?= htmlspecialchars($data['NamaAkun'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Kontak</label>
                                <input type="email" class="form-control" name="EmailAkun" 
                                       value="<?= htmlspecialchars($data['EmailAkun'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 border-top border-warning border-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon green me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background-color: #198754;">
                                <i class="bi bi-lock-fill text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Akses Portal</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username Login</label>
                            <input type="text" class="form-control bg-light" name="UsernameEmail" 
                                   value="<?= htmlspecialchars($data['UsernameEmail'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Akses</label>
                            <div class="input-group">
                                <input type="password" id="passEdit" class="form-control border-warning" name="PasswordEmail" 
                                       value="<?= htmlspecialchars($data['PasswordEmail'] ?? '') ?>">
                                <button class="btn btn-outline-warning" type="button" onclick="toggleEditPass()">
                                    <i id="eyeIcon" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold"><i class="bi bi-sticky me-2"></i>Catatan Internal</label>
                        <textarea class="form-control bg-light" name="Catatan" rows="4"><?= htmlspecialchars($data['Catatan'] ?? '') ?></textarea>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="submit" class="btn btn-warning btn-lg shadow-sm text-white fw-bold">
                                <i class="bi bi-arrow-repeat me-2"></i> Simpan Perubahan
                            </button>
                            <a href="index.php?halaman=controller" class="btn btn-light text-muted">Batalkan Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
function toggleEditPass() {
    const p = document.getElementById('passEdit');
    const i = document.getElementById('eyeIcon');
    if(p.type === 'password') {
        p.type = 'text';
        i.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        p.type = 'password';
        i.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>