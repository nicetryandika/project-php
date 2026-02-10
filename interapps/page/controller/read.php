<?php
require_once "./function/nocodb.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='alert alert-danger m-4'>ID tidak valid!</div>";
    exit;
}

$row = nocodb_get("/tables/mtvbg7xww4vqwj7/records/{$id}");
if (!$row) {
    echo "<div class='alert alert-warning m-4'>Data tidak ditemukan!</div>";
    exit;
}

$statusAktif = $row['StatusAktif'] ?? '-';
$isOnline = ($statusAktif === 'Aktif');
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --deep-purple: #1a1438;
        --accent-purple: #8155ff;
        --soft-purple: #f8f7ff;
        --text-main: #2d3436;
        --text-light: #636e72;
    }

    body {
        background: #f0f3ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    /* Main Container */
    .content-wrapper {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    /* Floating Hero Section */
    .hero-glass {
        background: linear-gradient(135deg, var(--deep-purple) 0%, #3d2b85 100%);
        border-radius: 40px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(31, 21, 71, 0.25);
        margin-bottom: -60px; /* Membuat efek overlap */
        z-index: 2;
    }

    .hero-pattern {
        position: absolute;
        top: 0; right: 0; opacity: 0.1;
        font-size: 20rem;
        transform: translate(30%, -30%);
        color: white;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        background: <?= $isOnline ? 'rgba(46, 213, 115, 0.2)' : 'rgba(164, 176, 190, 0.2)' ?>;
        color: <?= $isOnline ? '#2ed573' : '#f1f2f6' ?>;
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    /* Info Card Container */
    .info-container {
        background: white;
        border-radius: 40px;
        padding: 80px 40px 40px 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        z-index: 1;
        position: relative;
    }

    /* Grid Styling */
    .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .data-item label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .data-item span {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--deep-purple);
    }

    /* Access Section (Soft Look) */
    .access-section {
        background: var(--soft-purple);
        border-radius: 30px;
        padding: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: center;
        justify-content: space-between;
    }

    .cred-pill {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-purple);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
    }

    /* Buttons */
    .action-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .btn-edit {
        background: var(--accent-purple);
        color: white;
        padding: 14px 30px;
        border-radius: 18px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(129, 85, 255, 0.2);
    }

    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(129, 85, 255, 0.3);
        color: white;
    }

    .btn-back {
        padding: 14px 30px;
        border-radius: 18px;
        font-weight: 700;
        color: var(--text-light);
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #eee;
        color: var(--deep-purple);
    }

    .notes-box {
        margin-top: 2rem;
        padding: 1.5rem;
        border-left: 4px solid var(--accent-purple);
        background: #fbfbff;
        border-radius: 0 20px 20px 0;
    }
</style>

<div class="content-wrapper">
    <div class="hero-glass">
        <i class="bi bi-broadcast hero-pattern"></i>
        <div class="status-pill">
            <i class="bi bi-record-fill me-2"></i> <?= strtoupper($statusAktif) ?>
        </div>
        <h1 class="text-white fw-800 mb-2" style="font-size: 2.5rem;">
            <?= htmlspecialchars($row['NamaController'] ?? 'Starlink Unit'); ?>
        </h1>
        <div class="d-flex flex-wrap gap-4 text-white-50">
            <span><i class="bi bi-qr-code me-2"></i><?= htmlspecialchars($row['CodeController'] ?? 'N/A'); ?></span>
            <span><i class="bi bi-geo-alt me-2"></i><?= htmlspecialchars($row['LokasiPemasangan'] ?? '-'); ?></span>
            <span><i class="bi bi-box-seam me-2"></i><?= htmlspecialchars($row['PaketLayanan'] ?? '-'); ?></span>
        </div>
    </div>

    <div class="info-container">
        <div class="data-grid">
            <div class="data-item">
                <label>Model Hardware</label>
                <span><i class="bi bi-cpu me-2 text-muted"></i><?= htmlspecialchars($row['VersiHardware'] ?? '-'); ?></span>
            </div>
            <div class="data-item">
                <label>Kit Number</label>
                <span><?= htmlspecialchars($row['KitNumber'] ?? '-'); ?></span>
            </div>
            <div class="data-item">
                <label>Serial Number</label>
                <span><?= htmlspecialchars($row['SerialNumber'] ?? '-'); ?></span>
            </div>
            <div class="data-item">
                <label>IP Address</label>
                <span class="text-primary"><?= htmlspecialchars($row['IPAddress'] ?? 'Dynamic'); ?></span>
            </div>
        </div>

        <hr style="opacity: 0.1; margin: 2rem 0;">

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="cred-pill">
                    <div class="icon-circle"><i class="bi bi-person-check"></i></div>
                    <div>
                        <label class="info-label mb-0" style="font-size: 0.7rem; color: #999;">Pemilik Akun</label>
                        <div class="info-value fw-bold"><?= htmlspecialchars($row['NamaAkun'] ?? '-'); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cred-pill">
                    <div class="icon-circle"><i class="bi bi-envelope-at"></i></div>
                    <div>
                        <label class="info-label mb-0" style="font-size: 0.7rem; color: #999;">Email Terdaftar</label>
                        <div class="info-value fw-bold"><?= htmlspecialchars($row['EmailAkun'] ?? '-'); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cred-pill">
                    <div class="icon-circle"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <label class="info-label mb-0" style="font-size: 0.7rem; color: #999;">Aktivasi</label>
                        <div class="info-value fw-bold"><?= !empty($row['TglAktivasi']) ? date('d M Y', strtotime($row['TglAktivasi'])) : '-'; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="access-section">
            <div class="d-flex gap-4 flex-wrap">
                <div class="data-item">
                    <label>Username Portal</label>
                    <span class="text-dark"><?= htmlspecialchars($row['UsernameEmail'] ?? '-'); ?></span>
                </div>
                <div class="data-item">
                    <label>Password Portal</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="password" id="passView" value="<?= htmlspecialchars($row['PasswordEmail'] ?? ''); ?>" 
                               style="border:none; background:transparent; font-weight:700; width:100px; color: var(--deep-purple);" readonly>
                        <i class="bi bi-eye text-primary" style="cursor:pointer" onclick="togglePass()"></i>
                    </div>
                </div>
            </div>
            <div class="small text-muted fw-500">
                <i class="bi bi-shield-lock-fill me-1 text-success"></i> Encrypted Access
            </div>
        </div>

        <?php if(!empty($row['Catatan'])): ?>
        <div class="notes-box">
            <label class="info-label text-muted small fw-bold uppercase">Catatan Internal</label>
            <p class="mb-0 mt-1 fst-italic">"<?= nl2br(htmlspecialchars($row['Catatan'])) ?>"</p>
        </div>
        <?php endif; ?>

        <div class="action-group">
            <a href="index.php?halaman=edit_controller&id=<?= $id ?>" class="btn-edit">
                <i class="bi bi-pencil-fill me-2"></i> Perbarui Data
            </a>
            <a href="index.php?halaman=controller" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
</div>

<script>
function togglePass() {
    const p = document.getElementById('passView');
    p.type = p.type === 'password' ? 'text' : 'password';
}
</script>