<?php
$query = mysqli_query($connection, "SELECT * FROM users ORDER BY id DESC");
?>

<div class="page-heading">
    <h3>User Management</h3>
</div>

<div class="card">

    <!-- CARD HEADER -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">List User</h4>

        <a href="index.php?halaman=tambah_user" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <!-- CARD BODY -->
    <div class="card-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td>
                        <span class="badge bg-info"><?= $row['role'] ?></span>
                    </td>
                    <td>
                        <a href="index.php?halaman=edit_user&id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-warning">Edit</a>

                        <a href="index.php?halaman=hapus_user&id=<?= $row['id'] ?>"
                        onclick="return confirm('Hapus user ini?')"
                        class="btn btn-sm btn-danger">Hapus</a>

                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
