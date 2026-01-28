<?php
require_once "../../function/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if ($username && $password && $role) {

        mysqli_query(
            $connection,
            "INSERT INTO users (username, password, role)
             VALUES ('$username', '$password', '$role')"
        );
    }
}

// REDIRECT AMAN (TIDAK ADA HTML SEBELUM INI)
header("Location: ../../index.php?halaman=user");
exit;
