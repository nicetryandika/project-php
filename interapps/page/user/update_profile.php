<?php
include "function/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user_id'];
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    
    // Ambil data lama untuk cek foto lama
    $query_old = mysqli_query($connection, "SELECT avatar FROM users WHERE id='$id'");
    $data_old = mysqli_fetch_assoc($query_old);
    $nama_file_db = $data_old['avatar'];

    // Cek apakah ada file yang diupload
    if ($_FILES['avatar']['error'] === 4) {
        // Jika tidak upload foto baru, gunakan nama file lama
        $nama_file_baru = $nama_file_db;
    } else {
        // Proses Upload Foto Baru
        $filename = $_FILES['avatar']['name'];
        $tmp_name = $_FILES['avatar']['tmp_name'];
        
        // Generate nama unik agar tidak bentrok
        $ekstensi = pathinfo($filename, PATHINFO_EXTENSION);
        $nama_file_baru = uniqid() . "." . $ekstensi;
        
        // Tentukan folder tujuan (sesuaikan dengan path di <img> kamu)
        $folder_tujuan = "./assets/compiled/jpg/";
        
        if (move_uploaded_file($tmp_name, $folder_tujuan . $nama_file_baru)) {
            // Hapus foto lama jika bukan default.png
            if ($nama_file_db && $nama_file_db != 'default.png' && file_exists($folder_tujuan . $nama_file_db)) {
                unlink($folder_tujuan . $nama_file_db);
            }
        } else {
            echo "<script>alert('Gagal upload gambar');</script>";
            $nama_file_baru = $nama_file_db;
        }
    }

    // ... kode query update kamu ...
$update = mysqli_query($connection, "UPDATE users SET nama='$nama', avatar='$nama_file_baru' WHERE id='$id'");

if ($update) {
    // TAMBAHKAN INI: Update data session agar header ikut berubah
    $_SESSION['nama'] = $nama;
    $_SESSION['avatar'] = $nama_file_baru; 

    echo "<script>alert('Profil berhasil diperbarui!'); window.location='index.php?halaman=profile';</script>";
}

    // Update Database
    $update = mysqli_query($connection, "UPDATE users SET nama='$nama', avatar='$nama_file_baru' WHERE id='$id'");

    if ($update) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='index.php?halaman=profile';</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}