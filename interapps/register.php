<?php
session_start();
require_once "./function/connection.php";

// Jika sudah login, lempar ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?halaman=beranda');
    exit;
}

if (isset($_POST['register'])) {

    $nama     = mysqli_real_escape_string($connection, $_POST['nama']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $role     = $_POST['role'];

    // Cek username
    $cek = mysqli_query($connection, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan');</script>";
    } else {

        // INSERT USER
        $insert = mysqli_query($connection, "
            INSERT INTO users (nama, username, password, role, status, avatar)
            VALUES ('$nama', '$username', '$password', '$role', 'ACTIVE', 'default.png')
        ");

        if ($insert) {
            echo "
            <script>
                alert('Registrasi berhasil, silakan login');
                window.location.href='login.php';
            </script>
            ";
        } else {
            echo "<script>alert('Registrasi gagal');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Mazer CSS -->
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg">
</head>

<body>

<div id="auth">
    <div class="row h-100">

        <!-- LEFT FORM -->
        <div class="col-lg-5 col-12">
            <div id="auth-left">

                <!-- LOGO -->
                <div class="auth-logo mb-4">
                    <a href="login.php">
                        <img src="./assets/compiled/png/logoiw.png" alt="Logo">
                    </a>
                </div>

                <h2 class="auth-title">Buat Akun</h2>
                <p class="auth-subtitle mb-4">
                    Register user baru untuk akses sistem InterApps.
                </p>

                <!-- FORM -->
                <form method="post">

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl"
                               name="nama" placeholder="Nama Lengkap" required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl"
                               name="username" placeholder="Username" required>
                        <div class="form-control-icon">
                            <i class="bi bi-at"></i>
                        </div>
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl"
                               name="password" placeholder="Password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <select name="role" class="form-select form-select-xl" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="NOC">NOC</option>
                            <option value="PROVISIONING">Admin</option>
                            <option value="PROVISIONING">Provisioning</option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3"
                            name="register">
                        Register
                    </button>

                </form>

                <div class="text-center mt-4 text-lg fs-6">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="login.php" class="font-bold">
                            Login
                        </a>
                    </p>
                </div>

            </div>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>

    </div>
</div>
<script src="./assets/static/js/initTheme.js"></script>
</body>
</html>

