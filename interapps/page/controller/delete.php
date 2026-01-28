<?php
session_start();
include __DIR__ . "/../../function/connection.php";

/* Security: hanya NOC */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'NOC') {
    echo "<script>
        alert('Akses ditolak!');
        window.location='index.php?halaman=controller';
    </script>";
    exit;
}

/* Validasi ID */
if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID tidak ditemukan!');
        window.location='index.php?halaman=controller';
    </script>";
    exit;
}

$id = intval($_GET['id']);

/* Execute delete */
$query = mysqli_query(
    $connection,
    "DELETE FROM starlink_controller WHERE id = $id"
);

if ($query) {
    echo "<script>
        alert('Data controller berhasil dihapus');
        window.location='index.php?halaman=controller';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data');
        window.location='index.php?halaman=controller';
    </script>";
}
