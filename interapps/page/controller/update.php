<?php
include "function/connection.php";

$id              = $_POST['id'];
$nama_controller = $_POST['nama_controller'];
$serial_number   = $_POST['serial_number'];
$lokasi          = $_POST['lokasi'];
$ip_public       = $_POST['ip_public'];
$status          = $_POST['status'];
$keterangan      = $_POST['keterangan'];

$query = mysqli_query($connection, "
    UPDATE starlink_controller SET
        nama_controller='$nama_controller',
        serial_number='$serial_number',
        lokasi='$lokasi',
        ip_public='$ip_public',
        status='$status',
        keterangan='$keterangan'
    WHERE id='$id'
");

echo "<script>
    alert('Data controller berhasil diperbarui');
    window.location='index.php?halaman=controller';
</script>";
exit;

