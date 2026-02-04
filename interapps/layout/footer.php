<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2026 &copy; InterApps</p>
        </div>
        <div class="float-end">
            <p>
                Crafted with
                <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://github.com/nicetryandika">nicetryproject</a>
            </p>
        </div>
    </div>
</footer>

<!-- ================= SCRIPT GLOBAL ================= -->

<script>
function confirmLogout(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Yakin logout?',
        text: 'Anda akan keluar dari sistem',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?halaman=logout';
        }
    });
}
</script>

<script src="./assets/js/bootstrap.js"></script>
<script src="./assets/js/app.js"></script>

<!-- ================= DATATABLE ================= -->
<script src="./assets/extensions/simple-datatables/simple-datatables.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector("#table1");
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>
