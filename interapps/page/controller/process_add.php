<?php
// page/controller/process_add.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sesuaikan path ke file fungsi nocodb kamu
require_once "../../function/nocodb.php";

$isSuccess = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableId = "mtvbg7xww4vqwj7";
    
    // Payload disesuaikan dengan semua kolom baru di NocoDB
    $payload = [
        "CodeController"    => $_POST['CodeController'] ?? null,
        "NamaController"    => $_POST['NamaController'] ?? null,
        "VersiHardware"     => $_POST['VersiHardware'] ?? null,
        "KitNumber"         => $_POST['KitNumber'] ?? null,
        "SerialNumber"      => $_POST['SerialNumber'] ?? null,
        "IPAddress"         => $_POST['IPAddress'] ?? null,
        "LokasiPemasangan"  => $_POST['LokasiPemasangan'] ?? null,
        "TglAktivasi"       => $_POST['TglAktivasi'] ?? null,
        "NamaAkun"          => $_POST['NamaAkun'] ?? null,
        "EmailAkun"         => $_POST['EmailAkun'] ?? null,
        "PaketLayanan"      => $_POST['PaketLayanan'] ?? null,
        "StatusAktif"       => $_POST['StatusAktif'] ?? 'Aktif',
        "UsernameEmail"     => $_POST['UsernameEmail'] ?? null,
        "PasswordEmail"     => $_POST['PasswordEmail'] ?? null,
        "Catatan"           => $_POST['Catatan'] ?? null,
    ];

    // Kirim data ke NocoDB melalui fungsi yang sudah kamu buat
    $response = nocodb_post("/tables/{$tableId}/records", $payload);

    // Cek keberhasilan berdasarkan adanya 'Id' di response
    if (isset($response['Id']) || isset($response['id'])) {
        $isSuccess = true;
    } else {
        $errorMessage = is_array($response) ? json_encode($response) : "Terjadi kesalahan pada server database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing...</title>

    <link rel="shortcut icon" href="./assets/compiled/png/logo-bulat-transparan.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    <?php if ($isSuccess): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Unit <?= addslashes($_POST['NamaController']) ?> telah ditambahkan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "../../index.php?halaman=controller";
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Simpan',
            text: 'Error: <?= addslashes($errorMessage) ?>',
            confirmButtonText: 'Coba Lagi'
        }).then(() => {
            window.history.back();
        });
    <?php endif; ?>
    </script>
</body>
</html>