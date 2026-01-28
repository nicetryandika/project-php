<?php
include "./function/connection.php";

// Proteksi role
if (!in_array($_SESSION['role'], ['NOC', 'PROVISIONING'])) {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini');
        window.location='index.php?halaman=controller';
    </script>";
    exit;
}

// Proses simpan data
if (isset($_POST['simpan'])) {

    $nama_controller = $_POST['nama_controller'];
    $serial_number   = $_POST['serial_number'];
    $lokasi          = $_POST['lokasi'];
    $ip_public       = $_POST['ip_public'];
    $status          = $_POST['status'];
    $keterangan      = $_POST['keterangan'];

    $query = mysqli_query($connection, "
        INSERT INTO starlink_controller 
        (nama_controller, serial_number, lokasi, ip_public, status, keterangan)
        VALUES 
        ('$nama_controller', '$serial_number', '$lokasi', '$ip_public', '$status', '$keterangan')
    ");

    if ($query) {
        echo "<script>
            alert('Data controller berhasil ditambahkan');
            window.location='index.php?halaman=controller';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data');
        </script>";
    }
}
?>

<?php
// Proteksi role
if (!in_array($_SESSION['role'], ['NOC', 'PROVISIONING'])) {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini');
        window.location='index.php?halaman=controller';
    </script>";
    exit;
}
?>

<div class="page-heading">
    <h3>Tambah Controller Starlink</h3>
</div>

<div class="page-content">
    <section class="section">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Controller Starlink</h4>
            </div>

            <div class="card-body">
                <form action="#" method="post">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Controller</label>
                            <input type="text" name="nama_controller" class="form-control" placeholder="Starlink-JKT-01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Serial Number Starlink</label>
                            <input type="text" name="serial_number" class="form-control" placeholder="SL-XXXXXX" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Jakarta">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">IP Public</label>
                            <input type="text" name="ip_public" class="form-control" placeholder="103.xxx.xxx.xxx">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="OFFLINE">OFFLINE</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional"></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="simpan" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>

                        <a href="index.php?halaman=controller" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </section>
</div>
