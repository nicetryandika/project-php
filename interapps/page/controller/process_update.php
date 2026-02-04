<?php
// page/controller/process_update.php

// 1. Session & Path Management (Sama seperti add/delete untuk menghindari error path)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists("function/nocodb.php")) {
    require_once "function/nocodb.php";
} elseif (file_exists("../../function/nocodb.php")) {
    require_once "../../function/nocodb.php";
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/project-php/interapps/function/nocodb.php";
}

$isSuccess = false;
$debugMsg = "";

if (isset($_POST['submit'])) {
    $tableId = "mtvbg7xww4vqwj7";
    
    // 2. Siapkan Payload
    // PENTING: Kita harus mengirimkan ID di dalam body payload agar NocoDB tahu baris mana yang diupdate
    $payload = [
        "Id"             => $_POST['Id'], 
        "NamaController" => $_POST['NamaController'],
        "PaketLayanan"   => $_POST['PaketLayanan'],
        "NamaAkun"       => $_POST['NamaAkun'],
        "EmailAkun"      => $_POST['EmailAkun'],
        "StatusAktif"    => $_POST['StatusAktif']
    ];

    // 3. Kirim Request PATCH
    // Endpoint: /tables/{tableId}/records
    $response = nocodb_patch("/tables/{$tableId}/records", $payload);

    // 4. Validasi Response
    if (isset($response['Id']) || isset($response['id']) || (isset($response['msg']) && $response['msg'] == 'success')) {
        $isSuccess = true;
    } else {
        $isSuccess = false;
        $debugMsg = json_encode($response);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body>
    <script>
    <?php if ($isSuccess): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Update!',
            text: 'Data controller telah diperbarui.',
            confirmButtonColor: '#435ebe',
            timer: 2000
        }).then(() => {
            window.location.href = "../../index.php?halaman=controller";
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Update!',
            html: '<small><?= addslashes($debugMsg) ?></small>',
            confirmButtonColor: '#dc3545'
        }).then(() => {
            window.history.back();
        });
    <?php endif; ?>
    </script>
</body>
</html>