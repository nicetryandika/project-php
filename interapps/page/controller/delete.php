<?php
// page/controller/delete.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Smart Path Loading (Agar file nocodb.php pasti ketemu)
if (file_exists("function/nocodb.php")) {
    require_once "function/nocodb.php";
} elseif (file_exists("../../function/nocodb.php")) {
    require_once "../../function/nocodb.php";
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/project-php/interapps/function/nocodb.php";
}

$id = $_GET['id'] ?? null;
$tableId = "mtvbg7xww4vqwj7"; // ID Tabel Controller
$isSuccess = false;
$debugMsg = "";

if ($id) {
    // 2. Kirim request DELETE dengan payload ID
    // NocoDB butuh ID dalam bentuk array/object: { "Id": 123 }
    $payload = ["Id" => $id];
    
    $response = nocodb_delete("/tables/{$tableId}/records", $payload);
    
    // 3. Cek Response
    // Jika sukses, biasanya return "1" (jumlah row dihapus) atau object {Id: ...}
    // Jika gagal, biasanya ada key 'msg' atau 'error'
    if (isset($response['msg']) || isset($response['error'])) {
        $isSuccess = false;
        $debugMsg = json_encode($response);
    } else {
        // Asumsi sukses jika tidak ada pesan error
        $isSuccess = true;
    }
} else {
    $debugMsg = "Parameter ID tidak ditemukan di URL.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>body { font-family: sans-serif; }</style>
</head>
<body>
    <script>
    <?php if ($isSuccess): ?>
        Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: 'Data berhasil dihapus dari NocoDB.',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "index.php?halaman=controller";
        });
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Hapus',
            html: '<div style="text-align:left; font-size:12px; background:#f0f0f0; padding:10px;">' +
                  '<strong>Server Response:</strong><br>' +
                  '<?= addslashes($debugMsg) ?>' + 
                  '</div>',
            confirmButtonText: 'Kembali'
        }).then(() => {
            window.location.href = "index.php?halaman=controller";
        });
    <?php endif; ?>
    </script>
</body>
</html>