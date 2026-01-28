<?php
include "./function/connection.php";

// total controller
$q_total = mysqli_query($connection, "SELECT COUNT(*) AS total FROM starlink_controller");
$total = mysqli_fetch_assoc($q_total)['total'];

// online
$q_online = mysqli_query($connection, 
    "SELECT COUNT(*) AS online FROM starlink_controller WHERE status='ONLINE'");
$online = mysqli_fetch_assoc($q_online)['online'];

// offline
$q_offline = mysqli_query($connection, 
    "SELECT COUNT(*) AS offline FROM starlink_controller WHERE status='OFFLINE'");
$offline = mysqli_fetch_assoc($q_offline)['offline'];
?>

<div class="page-heading">
    <h3>Dashboard Starlink Controller</h3>
</div>

<div class="page-content">
    <section class="row">

        <!-- Total Controller -->
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon purple">
                                <i class="bi bi-router-fill"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">
                                Total Controller
                            </h6>
                            <h3><?= $total ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controller Online -->
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon green">
                                <i class="bi bi-wifi"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">
                                Controller Online
                            </h6>
                            <h3><?= $online ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controller Offline -->
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon red">
                                <i class="bi bi-wifi-off"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">
                                Controller Offline
                            </h6>
                            <h3><?= $offline ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Informasi -->
    <section class="section mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Informasi Sistem</h4>
            </div>
            <div class="card-body">
                <p>
                    Dashboard ini digunakan untuk memonitor dan mengelola
                    <strong>Controller Starlink</strong>.
                </p>
                <ul>
                    <li>Monitoring status controller</li>
                    <li>Manajemen data controller (CRUD)</li>
                    <li>Role akses: NOC, Admin, Provisioning</li>
                    <li>Integrasi NOCO DB (next phase)</li>
                </ul>
            </div>
        </div>
    </section>
</div>
