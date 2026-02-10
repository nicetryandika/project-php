<?php
/**
 * Halaman Edit Data Controller Starlink - InterApps Indonesian Deep Purple Style
 */
require_once "./function/nocodb.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID tidak ditemukan'); window.location='index.php?halaman=controller';</script>";
    exit;
}

// Ambil data lama dari NocoDB untuk ditampilkan di form
$row = nocodb_get("/tables/mtvbg7xww4vqwj7/records/{$id}");

if (!$row || isset($row['msg'])) {
    echo "<div class='alert alert-warning m-4'>Data tidak ditemukan di database!</div>";
    exit;
}
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --bg-soft: #f4f7ff;
        --deep-purple: #0f0a1e;
        --purple-primary: #7c4dff;
        --purple-hover: #4527a0;
        --text-main: #1a1a1a;
        --text-muted: #666;
    }

    body {
        background-color: var(--bg-soft);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Header Design */
    .form-header {
        margin-bottom: 30px;
        border-left: 5px solid var(--purple-primary);
        padding-left: 20px;
    }

    .form-header h2 {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--deep-purple);
        margin-bottom: 5px;
    }

    /* Card Styling */
    .main-card {
        background: #ffffff;
        border-radius: 30px;
        border: none;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(15, 10, 30, 0.05);
    }

    /* Group Label */
    .group-title {
        font-weight: 800;
        font-size: 0.75rem;
        color: var(--purple-primary);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .group-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    /* Input Field Styling */
    .input-box {
        margin-bottom: 20px;
    }

    .input-box label {
        display: block;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 8px;
        color: var(--deep-purple);
    }

    .custom-input {
        background: #f8faff !important;
        border: 2px solid transparent !important;
        border-radius: 15px !important;
        padding: 14px 18px !important;
        font-weight: 600 !important;
        color: var(--deep-purple) !important;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        background: #fff !important;
        border-color: var(--purple-primary) !important;
        box-shadow: 0 10px 20px rgba(124, 77, 255, 0.1) !important;
        outline: none;
        transform: translateY(-2px);
    }

    /* Portal Box Area */
    .portal-box {
        background: #fcfaff;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 25px;
        margin-top: 10px;
    }

    /* Buttons */
    .btn-save {
        background: linear-gradient(135deg, var(--purple-primary) 0%, var(--purple-hover) 100%);
        color: white;
        border: none;
        padding: 16px 35px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 10px 25px rgba(124, 77, 255, 0.3);
        transition: all 0.3s;
        width: 100%;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(124, 77, 255, 0.4);
    }

    .btn-back {
        background: transparent;
        color: var(--text-muted);
        border: none;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: var(--purple-primary);
    }

    .info-alert {
        background: #fff8eb;
        border-radius: 12px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #b07d00;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 30px;
        border: 1px solid #ffeeba;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Edit Perangkat</h2>
        <p>Perbarui informasi unit: <strong><?= htmlspecialchars($row['NamaController'] ?? 'Unit') ?></strong></p>
    </div>

    <form action="page/controller/process_update.php" method="POST">
        <input type="hidden" name="Id" value="<?= $id ?>">

        <div class="main-card">
            
            <div class="info-alert">
                <i class="bi bi-pencil-square"></i>
                Pastikan data yang Anda perbarui sudah sesuai dengan kondisi riil di lapangan.
            </div>

            <div class="group-title">Identitas Perangkat</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Kode Kontroler</label>
                        <input type="text" name="CodeController" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['CodeController'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Nama Perangkat</label>
                        <input type="text" name="NamaController" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['NamaController'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Model Hardware</label>
                        <select name="VersiHardware" class="form-select custom-input">
                            <?php $v = $row['VersiHardware'] ?? ''; ?>
                            <option value="Gen 2" <?= $v == 'Gen 2' ? 'selected' : '' ?>>Gen 2 (Actuated)</option>
                            <option value="Gen 3" <?= $v == 'Gen 3' ? 'selected' : '' ?>>Gen 3 (Standard)</option>
                            <option value="High Performance" <?= $v == 'High Performance' ? 'selected' : '' ?>>High Performance</option>
                            <option value="Flat High Performance" <?= $v == 'Flat High Performance' ? 'selected' : '' ?>>Flat High Performance</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Nomor Kit</label>
                        <input type="text" name="KitNumber" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['KitNumber'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Nomor Seri</label>
                        <input type="text" name="SerialNumber" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['SerialNumber'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="group-title" style="margin-top: 20px;">Konfigurasi Jaringan & Status</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Alamat IP</label>
                        <input type="text" name="IPAddress" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['IPAddress'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Tanggal Aktivasi</label>
                        <input type="date" name="TglAktivasi" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['TglAktivasi'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Status Operasional</label>
                        <select name="StatusAktif" class="form-select custom-input">
                            <?php $s = $row['StatusAktif'] ?? ''; ?>
                            <option value="Aktif" <?= $s == 'Aktif' ? 'selected' : '' ?>>Aktif / Online</option>
                            <option value="Non-Aktif" <?= $s == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif / Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Paket Layanan</label>
                        <select name="PaketLayanan" class="form-select custom-input">
                            <?php $p = $row['PaketLayanan'] ?? ''; ?>
                            <option value="Standard" <?= $p == 'Standard' ? 'selected' : '' ?>>Standard</option>
                            <option value="Priority" <?= $p == 'Priority' ? 'selected' : '' ?>>Priority</option>
                            <option value="Mobile" <?= $p == 'Mobile' ? 'selected' : '' ?>>Mobile Roam</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-box">
                <label>Lokasi Penempatan</label>
                <input type="text" name="LokasiPemasangan" class="form-control custom-input" 
                       value="<?= htmlspecialchars($row['LokasiPemasangan'] ?? '') ?>">
            </div>

            <div class="group-title" style="margin-top: 20px;">Akses Akun Portal</div>
            <div class="portal-box">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1 d-block">Nama Pemilik Akun</label>
                        <input type="text" name="NamaAkun" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['NamaAkun'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1 d-block">Email Terdaftar</label>
                        <input type="email" name="EmailAkun" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['EmailAkun'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold mb-1 d-block">Username Portal</label>
                        <input type="text" name="UsernameEmail" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['UsernameEmail'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold mb-1 d-block">Password Portal</label>
                        <input type="text" name="PasswordEmail" class="form-control custom-input" 
                               value="<?= htmlspecialchars($row['PasswordEmail'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="input-box mt-4">
                <label>Catatan Tambahan</label>
                <textarea name="Catatan" class="form-control custom-input" rows="3"><?= htmlspecialchars($row['Catatan'] ?? '') ?></textarea>
            </div>

            <div class="row mt-5 align-items-center">
                <div class="col-md-4">
                    <a href="index.php?halaman=controller" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Batal & Kembali
                    </a>
                </div>
                <div class="col-md-8 text-end">
                    <button type="submit" name="update" class="btn-save">
                        Perbarui Data <i class="bi bi-cloud-arrow-up ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>