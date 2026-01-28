<?php
if (!isset($_SESSION['user_id'])) {
    exit;
}

if (isset($_POST['submit'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $id = $_SESSION['user_id'];

    $q = mysqli_query($connection, "SELECT password FROM users WHERE id='$id'");
    $user = mysqli_fetch_assoc($q);

    if ($old !== $user['password']) {
        echo "<script>Swal.fire('Gagal','Password lama salah','error')</script>";
    } elseif ($new !== $confirm) {
        echo "<script>Swal.fire('Gagal','Konfirmasi password tidak cocok','error')</script>";
    } else {
        mysqli_query($connection, "UPDATE users SET password='$new' WHERE id='$id'");
        echo "
        <script>
        Swal.fire('Berhasil','Password berhasil diubah','success')
        </script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h4>Change Password</h4>
    </div>
    <div class="card-body">
        <form method="post">
            <input type="password" name="old_password" class="form-control mb-3" placeholder="Password Lama" required>
            <input type="password" name="new_password" class="form-control mb-3" placeholder="Password Baru" required>
            <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Ulangi Password Baru" required>
            <button name="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
