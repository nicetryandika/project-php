<?php
$now = time();

/**
 * =========================
 * SESSION (HANYA DI SINI)
 * =========================
 */
session_start();

/**
 * =========================
 * DATABASE CONNECTION
 * =========================
 */
require_once __DIR__ . "/function/connection.php";

/**
 * =========================
 * AUTH CHECK
 * =========================
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['timeout']) && $now > $_SESSION['timeout']) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inter Apps</title>

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app.css" />
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="./assets/compiled/css/error.css" />
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<script src="./assets/static/js/initTheme.js"></script>

<div id="app">

    <!-- SIDEBAR -->
    <?php require "./layout/sidebar.php"; ?>

    <div id="main" class="layout-navbar navbar-fixed">

        <!-- HEADER -->
        <?php require "./layout/header.php"; ?>

        <!-- CONTENT -->
        <div id="main-content">
            <?php require "./function/menu.php"; ?>
        </div>

        <!-- FOOTER -->
        <?php require "./layout/footer.php"; ?>

    </div>
</div>

<script src="./assets/static/js/components/dark.js"></script>
<script src="./assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="./assets/compiled/js/app.js"></script>
<script src="./assets/static/js/pages/sweetalert2.js"></script>
</body>
</html>
