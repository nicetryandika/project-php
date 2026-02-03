<?php

function nocodb_get($endpoint)
{
    $baseUrl = "https://toolshift.internetwork.net.id/api/v2";
    $token   = "-3e5ITaUjGPT73n7IOmk5_oxKiJaE2t87wvwI180";

    $url = $baseUrl . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "xc-token: $token",
            "Content-Type: application/json",
        ]
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}