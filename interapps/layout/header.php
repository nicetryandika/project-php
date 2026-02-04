<?php
$nama   = $_SESSION['nama'] ?? 'Guest';
$role   = $_SESSION['role'] ?? 'Unknown';
$avatar = $_SESSION['avatar'] ?? '1.jpg';

$roleLabel = match ($role) {
    'ADMIN' => 'Administrator',
    'NOC' => 'Network Operation',
    'PROVISIONING' => 'Provisioning',
    default => 'User'
};
?>

<header class="mb-3">
    <nav class="navbar navbar-expand navbar-light navbar-top sticky-top">
        <div class="container-fluid">
            
            <div class="d-flex align-items-center">
                <a href="#" class="burger-btn d-block me-3">
                    <i class="bi bi-justify fs-3 text-secondary"></i>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="ms-auto d-flex align-items-center">

                    <div class="theme-toggle-wrapper d-flex align-items-center me-3 pe-3 border-end">
                        <div class="theme-switch shadow-sm">
                            <i class="bi bi-sun-fill sun-icon-active"></i>
                            <div class="form-check form-switch p-0 m-0 mx-2">
                                <input class="form-check-input cursor-pointer shadow-none m-0" type="checkbox" id="toggle-dark" role="switch">
                            </div>
                            <i class="bi bi-moon-stars-fill moon-icon-active"></i>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="profile-link">
                            <div class="user-menu d-flex align-items-center">
                                <div class="user-name text-end me-3 d-none d-sm-block">
                                    <h6 class="mb-0 fw-bold text-emphasis-custom"><?= htmlspecialchars($nama) ?></h6>
                                    <p class="mb-0 text-muted role-text"><?= $roleLabel ?></p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md border-glow">
                                        <img src="./assets/compiled/jpg/<?= $avatar ?>" alt="User Avatar" class="rounded-circle shadow-sm">
                                        <span class="status-indicator online"></span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 animate-fade-in" style="min-width: 210px;">
                            <li><h6 class="dropdown-header">Sesi Aktif</h6></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="index.php?halaman=profile">
                                    <div class="icon-box bg-light-primary me-3">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <span>Profil Saya</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2" href="index.php?halaman=change_password">
                                    <div class="icon-box bg-light-info me-3">
                                        <i class="bi bi-shield-lock text-info"></i>
                                    </div>
                                    <span>Keamanan</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="index.php?halaman=logout" 
                                   onclick="return confirm('Apakah Anda ingin mengakhiri sesi?')">
                                    <div class="icon-box bg-light-danger me-3">
                                        <i class="bi bi-power text-danger"></i>
                                    </div>
                                    <span class="fw-bold">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* 1. Navbar Glassmorphism - Adaptif */
.navbar-top {
    background: var(--bs-body-bg) !important;
    opacity: 0.96;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--bs-border-color-translucent);
    padding: 0.8rem 1.5rem !important;
}

/* 2. Avatar Bulat Asli dengan Proteksi Background */
.border-glow {
    border: 2px solid var(--bs-body-bg);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
    border-radius: 50%;
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid var(--bs-body-bg);
    background-color: #57ca85;
}

/* 3. Theme Toggle Styling */
.theme-switch {
    display: flex;
    align-items: center;
    background: var(--bs-tertiary-bg);
    padding: 5px 10px;
    border-radius: 30px;
    border: 1px solid var(--bs-border-color);
}
.sun-icon-active { color: #ffab00; font-size: 0.9rem; }
.moon-icon-active { color: #5a8dee; font-size: 0.9rem; }

/* 4. Teks Dinamis (Mengikuti Tema) */
.text-emphasis-custom {
    color: var(--bs-heading-color) !important;
}

.role-text {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: var(--bs-secondary-color) !important;
}

/* 5. Dropdown Adaptif */
.dropdown-menu {
    border-radius: 15px !important;
    margin-top: 15px !important;
    background-color: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color) !important;
}

.dropdown-item {
    color: var(--bs-body-color);
}

.icon-box {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}

/* Warna Icon Box menggunakan transparansi agar masuk di semua tema */
.bg-light-primary { background: rgba(67, 94, 190, 0.1); }
.bg-light-info { background: rgba(0, 207, 221, 0.1); }
.bg-light-danger { background: rgba(231, 76, 60, 0.1); }

/* Animation */
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>