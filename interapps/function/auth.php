<?php
function require_role($roles = []) {
    if (!isset($_SESSION['role'])) {
        exit('Unauthorized');
    }

    if (!in_array($_SESSION['role'], $roles)) {
        echo "<script>
            Swal.fire('Akses Ditolak','Anda tidak memiliki akses','error')
            .then(()=>window.history.back())
        </script>";
        exit;
    }
}
