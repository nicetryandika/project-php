<?php
// SECURITY CHECK
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location='index.php?halaman=beranda'</script>";
    exit;
}

// hanya ADMIN boleh hapus
if ($_SESSION['role'] !== 'NOC') {
    echo "<script>
        alert('Akses ditolak');
        window.location='index.php?halaman=user';
    </script>";
    exit;
}

$id = $_GET['id'] ?? null;

// cegah hapus diri sendiri
if ($id == $_SESSION['user_id']) {
    echo "<script>
        alert('Tidak bisa menghapus akun sendiri');
        window.location='index.php?halaman=user';
    </script>";
    exit;
}

if ($id) {
    mysqli_query($connection, "DELETE FROM users WHERE id='$id'");
}

// redirect aman TANPA header
echo "<script>
    window.location='index.php?halaman=user';
</script>";
exit;
