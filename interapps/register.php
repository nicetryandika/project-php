<?php
session_start();
require_once "./function/connection.php";

// Jika sudah login, lempar ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php?halaman=beranda');
    exit;
}

$reg_status = null;
if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($connection, $_POST['nama']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $role     = $_POST['role'];

    $cek = mysqli_query($connection, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $reg_status = "exists";
    } else {
        $insert = mysqli_query($connection, "
            INSERT INTO users (nama, username, password, role, status, avatar)
            VALUES ('$nama', '$username', '$password', '$role', 'ACTIVE', 'default.png')
        ");
        $reg_status = ($insert) ? "success" : "failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InterApps | Join Infrastructure</title>
    
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-deep: #0f0a1e;
            --purple-primary: #7c4dff;
            --purple-light: #b388ff;
        }

        body {
            background-color: var(--bg-deep);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }

        #auth { height: 100vh; display: flex; }

        /* --- LEFT SECTION: Form (Sesuai Login) --- */
        .auth-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 0 40px 40px 0;
            z-index: 20;
            box-shadow: 20px 0 50px rgba(0,0,0,0.2);
        }

        .auth-card { width: 100%; max-width: 400px; padding: 20px; color: #333; }
        .auth-title { font-weight: 800; font-size: 2.2rem; color: #1a1a1a; margin-bottom: 0.5rem; }
        .auth-subtitle { color: #666; margin-bottom: 2rem; }

        /* Custom Input Styling */
        .custom-input, .custom-select {
            background: #f4f7ff;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 12px 15px 12px 50px;
            width: 100%;
            transition: all 0.3s;
            font-weight: 600;
        }

        .custom-select { padding-left: 15px; cursor: pointer; }

        .custom-input:focus, .custom-select:focus {
            outline: none;
            border-color: var(--purple-primary);
            background: #fff;
            box-shadow: 0 10px 20px rgba(124, 77, 255, 0.1);
        }

        .input-wrapper { position: relative; margin-bottom: 1rem; }
        .input-wrapper i {
            position: absolute; left: 20px; top: 50%;
            transform: translateY(-50%);
            color: var(--purple-primary);
            font-size: 1.1rem;
        }

        .btn-reg {
            background: linear-gradient(135deg, #7c4dff 0%, #4527a0 100%);
            color: white; border: none; padding: 14px; border-radius: 12px;
            font-weight: 700; width: 100%; margin-top: 1rem;
            box-shadow: 0 10px 30px rgba(124, 77, 255, 0.3);
            cursor: pointer; transition: 0.3s;
        }

        .btn-reg:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(124, 77, 255, 0.4); }

        /* --- RIGHT SECTION: Visual (Sesuai Login) --- */
        .auth-right {
            flex: 1.3; display: none;
            background: radial-gradient(circle at top right, #2e1a47, #0f0a1e);
            position: relative; overflow: hidden;
            flex-direction: column; justify-content: center; align-items: center;
        }

        @media (min-width: 992px) { .auth-right { display: flex; } }

        .glow {
            position: absolute; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(124, 77, 255, 0.15) 0%, transparent 70%);
            filter: blur(80px); z-index: 1;
        }
        .glow-1 { top: -100px; right: -50px; }

        .visual-container { 
            position: relative; z-index: 10; width: 100%; 
            max-width: 450px; display: flex; flex-direction: column; align-items: center; 
        }

        .visual-img {
            width: 45%; max-height: 220px; object-fit: contain; margin-bottom: 2rem;
            filter: drop-shadow(0 0 30px rgba(124, 77, 255, 0.3));
            animation: float 6s ease-in-out infinite;
        }

        .banner-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 2rem;
            width: 90%;
        }

        .banner-text h2 { color: #fff; font-weight: 800; font-size: 1.5rem; margin-bottom: 0.5rem; }
        .banner-text p { color: rgba(255, 255, 255, 0.5); font-size: 0.9rem; margin: 0; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>

<body>
    <?php if ($reg_status === "success"): ?>
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Akun Anda telah terdaftar.', confirmButtonColor: '#7c4dff' })
            .then(() => { window.location.href = 'login.php'; });
        </script>
    <?php elseif ($reg_status === "exists"): ?>
        <script>Swal.fire({ icon: 'warning', title: 'Username Digunakan', text: 'Silakan gunakan username lain.', confirmButtonColor: '#7c4dff' });</script>
    <?php elseif ($reg_status === "failed"): ?>
        <script>Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan sistem.', confirmButtonColor: '#7c4dff' });</script>
    <?php endif; ?>

    <div id="auth">
        <div class="auth-left">
            <div class="auth-card">
                <div class="auth-logo mb-4">
                    <img src="./assets/compiled/png/logoiw.png" alt="Logo" height="45">
                </div>
                
                <h1 class="auth-title">Buat Akun.</h1>
                <p class="auth-subtitle">Daftarkan diri Anda untuk akses InterApps.</p>

                <form method="POST">
                    <div class="input-wrapper">
                        <i class="bi bi-person-vcard"></i>
                        <input type="text" name="nama" class="custom-input" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="input-wrapper">
                        <i class="bi bi-at"></i>
                        <input type="text" name="username" class="custom-input" placeholder="Username" required>
                    </div>

                    <div class="input-wrapper">
                        <i class="bi bi-shield-lock"></i>
                        <input type="password" name="password" class="custom-input" placeholder="Password" required>
                    </div>

                    <div class="input-wrapper">
                        <select name="role" class="custom-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="NOC">NOC</option>
                            <option value="ADMIN">Admin</option>
                            <option value="PROVISIONING">Provisioning</option>
                        </select>
                    </div>

                    <button type="submit" name="register" class="btn-reg">
                        CREATE ACCOUNT
                    </button>
                </form>

                <p class="text-center small mt-4">
                    Sudah punya akun? <a href="login.php" class="fw-bold text-decoration-none" style="color: var(--purple-primary)">Log In</a>
                </p>
                <p class="text-center text-muted small mt-5">© 2026 InterApps System</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="glow glow-1"></div>
            <div class="visual-container">
                <img src="./assets/compiled/png/wangwang.png" alt="Mascot" class="visual-img">
                <div class="banner-card">
                    <div class="banner-text">
                        <h2>Ready to Scale?</h2>
                        <p>Bergabunglah dengan ekosistem NOC tercepat dan terintegrasi saat ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>