<?php
session_start();
require_once "../../function/connection.php";

$id = $_GET['id'] ?? null;

// Cegah hapus diri sendiri
if ($id == $_SESSION['user_id']) {
    header("Location: ../../index.php?halaman=user");
    exit;
}

// (opsional) hanya ADMIN
if ($_SESSION['role'] !== 'ADMIN') {
    header("Location: ../../index.php?halaman=beranda");
    exit;
}

if ($id) {
    mysqli_query(
        $connection,
        "DELETE FROM users WHERE id='$id'"
    );
}

header("Location: ../../index.php?halaman=user");
exit;
