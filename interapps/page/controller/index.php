<?php
// ambil data controller
$query = mysqli_query($connection, "SELECT * FROM starlink_controller ORDER BY id DESC");
?>

<div class="page-heading">
    <h3>Controller Management</h3>
</div>

<div class="card">

    <!-- HEADER -->
    <div class="card-header d-flex justify-content-between align-items-center">

        <!-- LEFT ACTION -->
        <a href="index.php?halaman=tambah_controller"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Controller
        </a>

        <!-- SEARCH -->
        <input type="text"
               id="searchController"
               class="form-control w-25"
               placeholder="Cari SN / Lokasi / IP / Status">
    </div>

    <!-- BODY -->
    <div class="card-body">
        <table class="table table-striped" id="tableController">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Serial Number</th>
                    <th>Lokasi</th>
                    <th>IP Public</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['serial_number']) ?></td>
                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                    <td><?= htmlspecialchars($row['ip_public']) ?></td>

                    <!-- STATUS BADGE -->
                    <td>
                        <?php if ($row['status'] === 'ONLINE') : ?>
                            <span class="badge bg-success">ONLINE</span>
                        <?php else : ?>
                            <span class="badge bg-danger">OFFLINE</span>
                        <?php endif; ?>
                    </td>

                    <!-- ACTION -->
                    <td>
                        <a href="index.php?halaman=edit_controller&id=<?= $row['id'] ?>"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="index.php?halaman=hapus_controller&id=<?= $row['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Hapus controller ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- DATATABLE SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const table = $('#tableController').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        info: true,
        dom: 'rtip', // hide default search
        language: {
            emptyTable: "Data controller tidak tersedia"
        }
    });

    // Custom search
    document.getElementById('searchController').addEventListener('keyup', function () {
        table.search(this.value).draw();
    });

});
</script>
