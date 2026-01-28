<?php
require_once "../../function/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id       = $_POST['id'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if ($password !== '') {
        // update dengan password baru
        mysqli_query(
            $connection,
            "UPDATE users 
             SET username='$username', password='$password', role='$role'
             WHERE id='$id'"
        );
    } else {
        // update tanpa ganti password
        mysqli_query(
            $connection,
            "UPDATE users 
             SET username='$username', role='$role'
             WHERE id='$id'"
        );
    }
}

header("Location: ../../index.php?halaman=user");
exit;
