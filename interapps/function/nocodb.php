<?php
/**
 * Helper Functions untuk API NocoDB
 * Lokasi: function/nocodb.php
 */

// Konfigurasi Global
define('NOCODB_BASE_URL', 'https://toolshift.internetwork.net.id/api/v2');
define('NOCODB_TOKEN', '-3e5ITaUjGPT73n7IOmk5_oxKiJaE2t87wvwI180');

/**
 * 1. GET - Mengambil Data (Read)
 */
function nocodb_get($endpoint) {
    $url = NOCODB_BASE_URL . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "xc-token: " . NOCODB_TOKEN,
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        return ['error' => curl_error($ch)];
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

/**
 * 2. POST - Menambah Data Baru (Create)
 */
function nocodb_post($endpoint, $data) {
    $url = NOCODB_BASE_URL . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "xc-token: " . NOCODB_TOKEN,
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

/**
 * 3. PATCH - Mengupdate Data (Update/Edit)
 * (Akan digunakan nanti saat fitur Edit dibuat)
 */
function nocodb_patch($endpoint, $data) {
    $url = NOCODB_BASE_URL . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "PATCH", // Menggunakan method PATCH
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "xc-token: " . NOCODB_TOKEN,
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

/**
 * 4. DELETE - Menghapus Data
 * PERBAIKAN: Ditambahkan parameter $data untuk mengirim ID
 */
function nocodb_delete($endpoint, $data = []) {
    $url = NOCODB_BASE_URL . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => [
            "xc-token: " . NOCODB_TOKEN,
            "Content-Type: application/json"
        ]
    ];

    // Jika ada data (ID) yang dikirim, masukkan ke Body Request
    if (!empty($data)) {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }

    curl_setopt_array($ch, $options);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
?>