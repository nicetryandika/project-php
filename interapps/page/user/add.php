<div class="page-heading">
    <h3>Tambah User</h3>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="page/user/process_add.php">
            
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="text" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="ADMIN">ADMIN</option>
                    <option value="NOC">NOC</option>
                    <option value="PROVISIONING">PROVISIONING</option>
                </select>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="index.php?halaman=user" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
