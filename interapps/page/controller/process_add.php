<?php
// page/controller/process_add.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan path nocodb.php benar
require_once "../../function/nocodb.php";

$isSuccess = false;
$errorMessage = "";

if (isset($_POST['submit'])) {
    $tableId = "mtvbg7xww4vqwj7";
    
    // Menangkap semua inputan dari form
    $payload = [
        "NamaController"    => $_POST['NamaController'],
        "PaketLayanan"      => $_POST['PaketLayanan'],
        "LokasiPemasangan"  => $_POST['LokasiPemasangan'],
        "NamaAkun"          => $_POST['NamaAkun'],
        "EmailAkun"         => $_POST['EmailAkun'],
        "StatusAktif"       => $_POST['StatusAktif'],
        "UsernameEmail"     => $_POST['UsernameEmail'],
        "PasswordEmail"     => $_POST['PasswordEmail'],
        "Catatan"           => $_POST['Catatan'],
    ];

    $response = nocodb_post("/tables/{$tableId}/records", $payload);

    if (isset($response['Id']) || isset($response['id'])) {
        $isSuccess = true;
    } else {
        $errorMessage = json_encode($response);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    <?php if ($isSuccess): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Unit Controller baru telah ditambahkan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "../../index.php?halaman=controller";
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan',
            text: 'Error: <?= addslashes($errorMessage) ?>',
            confirmButtonText: 'Coba Lagi'
        }).then(() => {
            window.history.back();
        });
    <?php endif; ?>
    </script>
</body>
</html>