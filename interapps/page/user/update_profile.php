<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "function/connection.php";

$id   = $_SESSION['user_id'];
$nama = mysqli_real_escape_string($connection, $_POST['nama']);

$avatarName = $_SESSION['avatar'];

if (!empty($_FILES['avatar']['name'])) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $avatarName = 'avatar_' . $id . '.' . $ext;
    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        './assets/compiled/jpg/' . $avatarName
    );
}

mysqli_query($connection,
    "UPDATE users SET nama='$nama', avatar='$avatarName' WHERE id='$id'"
);

// update session
$_SESSION['nama']   = $nama;
$_SESSION['avatar'] = $avatarName;

echo "
<script>
alert('Profile berhasil diperbarui');
window.location.href='index.php?halaman=profile';
</script>
";
