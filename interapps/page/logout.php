<?php
/**
 * =========================
 * LOGOUT USER
 * =========================
 * - Hapus semua session
 * - Destroy session
 * - Redirect ke login
 */

// pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// hapus semua data session
$_SESSION = [];

// destroy session
session_destroy();
?>

<script>
Swal.fire({
    title: 'Logout Berhasil',
    text: 'Anda telah keluar dari sistem',
    icon: 'success',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
}).then(() => {
    window.location.href = 'login.php';
});
</script>
