<?php
include "function/connection.php";

$id = $_GET['id'];

$query = mysqli_query($connection, 
    "SELECT * FROM starlink_controller WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);
?>

<div class="page-heading">
    <h3>Edit Controller Starlink</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="index.php?halaman=update_controller" method="POST">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <div class="mb-3">
                <label>Nama Controller</label>
                <input type="text" name="nama_controller" class="form-control"
                       value="<?= $data['nama_controller'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Serial Number</label>
                <input type="text" name="serial_number" class="form-control"
                       value="<?= $data['serial_number'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" class="form-control"
                       value="<?= $data['lokasi'] ?>">
            </div>

            <div class="mb-3">
                <label>IP Public</label>
                <input type="text" name="ip_public" class="form-control"
                       value="<?= $data['ip_public'] ?>">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="ONLINE" <?= $data['status']=='ONLINE'?'selected':'' ?>>ONLINE</option>
                    <option value="OFFLINE" <?= $data['status']=='OFFLINE'?'selected':'' ?>>OFFLINE</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"><?= $data['keterangan'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Update
            </button>
            <a href="index.php?halaman=controller" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>
