<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "function/connection.php";

$id = $_SESSION['user_id'];

$query = mysqli_query($connection, "SELECT * FROM users WHERE id='$id'");
$user  = mysqli_fetch_assoc($query);
?>

<div class="page-heading">
    <h3>Profile Saya</h3>
</div>

<div class="page-content">
    <div class="row">

        <!-- INFO PROFILE -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="./assets/compiled/jpg/<?= $user['avatar'] ?: 'default.png' ?>"
                         class="img-fluid rounded-circle mb-3"
                         width="120">

                    <h5><?= htmlspecialchars($user['nama']) ?></h5>
                    <p class="text-muted"><?= htmlspecialchars($user['role']) ?></p>
                </div>
            </div>
        </div>

        <!-- FORM EDIT -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <form method="post" enctype="multipart/form-data"
                          action="index.php?halaman=update_profile">

                        <div class="form-group mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama"
                                   class="form-control"
                                   value="<?= htmlspecialchars($user['nama']) ?>"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Ganti Foto</label>
                            <input type="file" name="avatar"
                                   class="form-control">
                        </div>

                        <button class="btn btn-primary">
                            Simpan Perubahan
                        </button>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
