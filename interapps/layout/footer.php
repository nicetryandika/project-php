<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2023 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <p>
                Crafted with
                <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Saugi</a>
            </p>
        </div>
    </div>
</footer>

<!-- ================= SCRIPT GLOBAL ================= -->

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
