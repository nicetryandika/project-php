<?php
include "./function/connection.php";
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php?halaman=beranda');
    exit;
}

$login_status = null;
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' AND status='ACTIVE'");
    $user = mysqli_fetch_assoc($query);

    if ($user && $password === $user['password']) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['avatar']   = $user['avatar'];
        $_SESSION['nama']     = $user['nama'];
        $_SESSION['role']     = $user['role'];
        $login_status = "success";
    } else {
        $login_status = "failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InterApps | Dashboard</title>

    <link rel="shortcut icon" href="./assets/compiled/png/logo-bulat-transparan.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-deep: #0f0a1e;
            --purple-primary: #7c4dff;
            --purple-light: #b388ff;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-deep);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }

        #auth {
            height: 100vh;
            display: flex;
        }

        /* --- LEFT SECTION: Form --- */
        .auth-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff; /* Bersih seperti di gambar */
            border-radius: 0 40px 40px 0;
            z-index: 20;
            box-shadow: 20px 0 50px rgba(0,0,0,0.2);
        }

        .auth-card {
            width: 100%;
            max-width: 380px;
            padding: 20px;
            color: #333;
        }

        .auth-title { font-weight: 800; font-size: 2.2rem; color: #1a1a1a; margin-bottom: 0.5rem; }
        .auth-subtitle { color: #666; margin-bottom: 2rem; }

        .custom-input {
            background: #f4f7ff;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 14px 15px 14px 50px;
            width: 100%;
            transition: all 0.3s;
            font-weight: 600;
        }

        .custom-input:focus {
            outline: none;
            border-color: var(--purple-primary);
            background: #fff;
            box-shadow: 0 10px 20px rgba(124, 77, 255, 0.1);
        }

        .input-wrapper { position: relative; margin-bottom: 1.2rem; }
        .input-wrapper i {
            position: absolute;
            left: 20px; top: 50%;
            transform: translateY(-50%);
            color: var(--purple-primary);
            font-size: 1.2rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #7c4dff 0%, #4527a0 100%);
            color: white; border: none; padding: 16px; border-radius: 15px;
            font-weight: 700; width: 100%; margin-top: 1rem;
            box-shadow: 0 10px 30px rgba(124, 77, 255, 0.4);
            cursor: pointer; transition: 0.3s;
        }

        .btn-login:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(124, 77, 255, 0.5); }

        /* --- RIGHT SECTION: Visual (Estetik Smooth) --- */
        .auth-right {
            flex: 1.3;
            display: none;
            background: radial-gradient(circle at top right, #2e1a47, #0f0a1e);
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @media (min-width: 992px) { .auth-right { display: flex; } }

        /* Background Glow Blobs */
        .glow {
            position: absolute; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(124, 77, 255, 0.2) 0%, transparent 70%);
            filter: blur(80px); z-index: 1;
        }
        .glow-1 { top: -100px; right: -50px; }
        .glow-2 { bottom: -100px; left: -50px; background: rgba(233, 30, 99, 0.15); }

        .visual-container { 
            position: relative; z-index: 10; width: 100%; 
            max-width: 500px; display: flex; flex-direction: column; align-items: center; 
        }

        .visual-img {
            width: 50%; /* Kecil & Rapi */
            max-height: 250px;
            object-fit: contain;
            margin-bottom: 3rem;
            filter: drop-shadow(0 0 30px rgba(124, 77, 255, 0.4));
            animation: float 6s ease-in-out infinite;
        }

        /* Floating Glass Card */
        .banner-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 2.5rem;
            text-align: left;
            box-shadow: 0 40px 80px rgba(0,0,0,0.4);
            width: 90%;
            position: relative;
        }

        .banner-card::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        .banner-text h2 { 
            color: #fff; font-weight: 800; font-size: 1.8rem; margin-bottom: 1rem;
            line-height: 1.2;
        }
        .banner-text p { color: rgba(255, 255, 255, 0.6); font-size: 1rem; line-height: 1.6; }
        
        .banner-badge {
            display: inline-flex; align-items: center;
            background: rgba(124, 77, 255, 0.2);
            color: var(--purple-light); padding: 8px 16px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 700; margin-top: 1.5rem;
            border: 1px solid rgba(124, 77, 255, 0.3);
            text-transform: uppercase; letter-spacing: 1px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>

<body>
    <?php if ($login_status === "success"): ?>
        <script>
            Swal.fire({ icon: 'success', title: 'Welcome Back', text: 'Securing your session...', timer: 1500, showConfirmButton: false, background: '#fff', color: '#333' })
            .then(() => { window.location.href = 'index.php?halaman=beranda'; });
        </script>
    <?php elseif ($login_status === "failed"): ?>
        <script>
            Swal.fire({ icon: 'error', title: 'Access Denied', text: 'Invalid credentials.', confirmButtonColor: '#7c4dff' });
        </script>
    <?php endif; ?>

    <div id="auth">
        <div class="auth-left">
            <div class="auth-card">
                <div class="auth-logo mb-4">
                    <img src="./assets/compiled/png/logoiw.png" alt="Logo" height="50">
                </div>
                
                <h1 class="auth-title">Welcome Back.</h1>
                <p class="auth-subtitle">Sign in to manage your infrastructure.</p>

                <form method="POST">
                    <div class="input-wrapper">
                        <i class="bi bi-person-circle"></i>
                        <input type="text" name="username" class="custom-input" placeholder="Username" required autofocus>
                    </div>

                    <div class="input-wrapper">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="password" name="password" class="custom-input" placeholder="Password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label text-secondary small" for="remember">Remember Me</label>
                        </div>
                        <a href="#" class="small fw-bold text-decoration-none" style="color: var(--purple-primary)">Forgot Password?</a>
                    </div>

                    <button type="submit" name="login" class="btn-login">
                        LOG IN SYSTEM
                    </button>

                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Belum memiliki akses? 
                            <a href="register.php" class="fw-bold text-decoration-none" style="color: var(--purple-primary)">
                                Daftar Akun Baru
                            </a>
                        </p>
                    </div>
                </form>

                <p class="text-center text-muted small mt-5">© 2026 InterApps System</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="glow glow-1"></div>
            <div class="glow glow-2"></div>
            
            <div class="visual-container">
                <img src="./assets/compiled/png/wangwang.png" alt="Mascot" class="visual-img">
                
                <div class="banner-card">
                    <div class="banner-text">
                        <h2>High Speed Internet without Boundaries</h2>
                        <p>Seamless integration for your entire NOC infrastructure. Built for speed, secured for scale.</p>
                    </div>
                    <div class="banner-badge">
                        <i class="bi bi-cpu-fill me-2"></i> Secured Infrastructure
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>