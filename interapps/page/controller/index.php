<?php
include "./function/connection.php";

$query = mysqli_query($connection, "SELECT * FROM starlink_controller ORDER BY id DESC");
?>

<div class="page-heading">
    <h3>Data Controller Starlink</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List Controller</h4>

                    <?php if ($_SESSION['role'] != 'ADMIN'): ?>
                        <a href="index.php?halaman=tambah_controller" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Controller
                        </a>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Controller</th>
                                <th>Serial Number</th>
                                <th>Lokasi</th>
                                <th>IP Public</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama_controller']) ?></td>
                                    <td><?= htmlspecialchars($row['serial_number']) ?></td>
                                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                    <td><?= htmlspecialchars($row['ip_public']) ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'ONLINE'): ?>
                                            <span class="badge bg-success">ONLINE</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">OFFLINE</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                    <td>
                                        <a href="index.php?halaman=edit_controller&id=<?= $row['id'] ?>"  
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <?php if ($_SESSION['role'] == 'NOC'): ?>
                                            <a href="index.php?halaman=hapus_controller&id=<?= $row['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
