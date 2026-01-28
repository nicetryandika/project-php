<?php
// fallback jika session belum ada
$nama = $_SESSION['nama'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'Unknown';

// mapping role biar lebih rapi ditampilkan
$roleLabel = match ($role) {
    'ADMIN' => 'Administrator',
    'NOC' => 'NOC',
    'PROVISIONING' => 'Provisioning',
    default => 'User'
};
?>

<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">

            <!-- Toggle Sidebar -->
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <div class="collapse navbar-collapse">
                <div class="dropdown ms-auto">

                    <!-- USER DROPDOWN -->
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex align-items-center">

                            <!-- USER INFO -->
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">
                                    <?= htmlspecialchars($nama) ?>
                                </h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    <?= $roleLabel ?>
                                </p>
                            </div>

                            <!-- AVATAR -->
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="./assets/compiled/jpg/1.jpg" alt="User Avatar">
                                </div>
                            </div>

                        </div>
                    </a>

                    <!-- DROPDOWN MENU -->
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">
                                Hello, <?= htmlspecialchars($nama) ?>
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider" /></li>

                        <li>
                            <a class="dropdown-item"
                               href="index.php?halaman=logout"
                               onclick="return confirm('Yakin ingin logout?')">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </nav>
</header>
