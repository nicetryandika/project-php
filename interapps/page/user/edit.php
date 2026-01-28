<?php
$id = $_GET['id'] ?? null;

$query = mysqli_query(
    $connection,
    "SELECT * FROM users WHERE id = '$id'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "<div class='alert alert-danger'>User tidak ditemukan</div>";
    return;
}
?>

<div class="page-heading">
    <h3>Edit User</h3>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="page/user/process_update.php">

            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username"
                       value="<?= htmlspecialchars($user['username']) ?>"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password <small>(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="ADMIN" <?= $user['role']=='ADMIN'?'selected':'' ?>>ADMIN</option>
                    <option value="NOC" <?= $user['role']=='NOC'?'selected':'' ?>>NOC</option>
                    <option value="PROVISIONING" <?= $user['role']=='PROVISIONING'?'selected':'' ?>>PROVISIONING</option>
                </select>
            </div>

            <button class="btn btn-warning">Update</button>
            <a href="index.php?halaman=user" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>
