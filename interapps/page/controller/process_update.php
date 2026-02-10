<?php
// page/controller/proses_update.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../function/nocodb.php";

$isSuccess = false;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableId = "mtvbg7xww4vqwj7";
    $id = $_POST['Id']; // ID Record dari NocoDB

    // Data yang akan diupdate
    $payload = [
        "Id"                => $id, // Diperlukan untuk identifikasi PATCH
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
        "StatusAktif"       => $_POST['StatusAktif'] ?? 'Aktif',
        "UsernameEmail"     => $_POST['UsernameEmail'] ?? null,
        "PasswordEmail"     => $_POST['PasswordEmail'] ?? null,
        "Catatan"           => $_POST['Catatan'] ?? null,
    ];

    /**
     * Menggunakan PATCH untuk update record.
     * Fungsi nocodb_patch biasanya menerima array of objects: [{$data}]
     */
    $response = nocodb_patch("/tables/{$tableId}/records", [$payload]);

    // Validasi response (NocoDB mengembalikan list record yang diupdate jika berhasil)
    if (isset($response[0]['Id']) || isset($response['Id'])) {
        $isSuccess = true;
    } else {
        $errorMessage = is_array($response) ? json_encode($response) : "Gagal memperbarui database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="./assets/compiled/png/logo-bulat-transparan.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    <?php if ($isSuccess): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Diperbarui',
            text: 'Data unit telah diperbarui di sistem.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "../../index.php?halaman=controller";
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Update',
            text: 'Error: <?= addslashes($errorMessage) ?>',
            confirmButtonText: 'Kembali'
        }).then(() => {
            window.history.back();
        });
    <?php endif; ?>
    </script>
</body>
</html>