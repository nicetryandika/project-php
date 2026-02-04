<?php
/**
 * Sidebar Navigation Component
 * Mengatur tampilan logo, menu dinamis berdasarkan role, dan theme toggle.
 */

$beranda = false;
$controller = false;
$tambah_controller = false;
$user = false;

$halaman = $_GET['halaman'] ?? 'beranda';

switch ($halaman) {
    case 'beranda': $beranda = true; break;
    case 'controller': $controller = true; break;
    case 'tambah_controller': $tambah_controller = true; break;
    case 'user': $user = true; break;
}
?>

<div id="sidebar">
    <div class="sidebar-wrapper active shadow-sm">
        
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo">
                    <a href="index.php?halaman=beranda">
                        <img src="./assets/compiled/png/logoiw.png" alt="Logo" 
                             style="height: 55px !important; width: auto; max-width: 100%; transition: 0.3s;" />
                    </a>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                
                <li class="sidebar-title">Menu Utama</li>

                <li class="sidebar-item <?= $beranda ? 'active' : '' ?>">
                    <a href="index.php?halaman=beranda" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Starlink Management</li>

                <li class="sidebar-item <?= $controller ? 'active' : '' ?>">
                    <a href="index.php?halaman=controller" class="sidebar-link">
                        <i class="bi bi-hdd-network-fill"></i>
                        <span>Data Controller</span>
                    </a>
                </li>

                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'NOC' || $_SESSION['role'] === 'PROVISIONING')) : ?>
                    <li class="sidebar-item <?= $tambah_controller ? 'active' : '' ?>">
                        <a href="index.php?halaman=tambah_controller" class="sidebar-link">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Tambah Controller</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'NOC') : ?>
                    <li class="sidebar-title">User Management</li>
                    <li class="sidebar-item <?= $user ? 'active' : '' ?>">
                        <a href="index.php?halaman=user" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Data User</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- <li class="sidebar-title">Sistem & Preferensi</li>

                <li class="sidebar-item px-3">
                    <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light-secondary shadow-sm" style="background: rgba(0,0,0,0.05);">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-sun-fill me-2 text-warning" id="sun-icon"></i>
                            <span class="small fw-bold">Theme</span>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input ms-0 cursor-pointer shadow-none" type="checkbox" id="toggle-dark">
                        </div>
                        <i class="bi bi-moon-fill text-primary" id="moon-icon"></i>
                    </div>
                </li> -->

                <!-- <li class="sidebar-item mt-2">
                    <a href="logout.php" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right text-danger"></i>
                        <span>Keluar Akun</span>
                    </a>
                </li> -->

            </ul>
        </div>
    </div>
</div>

<style>
/* Memastikan cursor pointer pada switch */
.cursor-pointer { cursor: pointer; }
/* Menghaluskan transisi logo saat hover */
.logo img:hover { transform: scale(1.05); }
/* Styling tambahan untuk box theme toggle */
.bg-light-secondary { border-radius: 10px; }
</style>