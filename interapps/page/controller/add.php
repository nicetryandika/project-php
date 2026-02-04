<?php
// page/controller/add.php
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="fw-bold">Registrasi Unit Starlink</h3>
                <p class="text-subtitle text-muted">Pastikan data kredensial diisi dengan teliti untuk memudahkan manajemen remote.</p>
            </div>
        </div>
    </div>
</div>

<section class="section mt-4">
    <form action="page/controller/process_add.php" method="POST">
        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon purple me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-hdd-network text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Informasi Teknis & Lokasi</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Nama Controller <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-6" name="NamaController" placeholder="e.g. STARLINK-STN-JKT-01" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Paket Layanan</label>
                                <select class="form-select" name="PaketLayanan">
                                    <option value="Standard">Standard</option>
                                    <option value="Priority">Priority</option>
                                    <option value="Mobile-Priority">Mobile Priority</option>
                                    <option value="Business">Business</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Awal</label>
                                <select class="form-select text-success fw-bold" name="StatusAktif">
                                    <option value="Aktif">● Aktif</option>
                                    <option value="Nonaktif">○ Nonaktif</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Lokasi Pemasangan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" name="LokasiPemasangan" placeholder="Alamat lengkap atau koordinat site">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon blue me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-badge text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Kepemilikan Akun</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Pemilik Akun <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="NamaAkun" placeholder="Nama lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Kontak <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="EmailAkun" placeholder="email@perusahaan.com" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 border-top border-primary border-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stats-icon green me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-shield-lock text-white fs-5"></i>
                            </div>
                            <h5 class="mb-0">Kredensial Akses</h5>
                        </div>

                        <div class="alert alert-light-warning color-warning small mb-4">
                            <i class="bi bi-exclamation-triangle"></i> Data ini bersifat rahasia. Digunakan untuk keperluan login remote.
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username / Email Login</label>
                            <input type="text" class="form-control" name="UsernameEmail" placeholder="ID Akun Starlink">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Akses</label>
                            <div class="input-group">
                                <input type="password" id="passInput" class="form-control" name="PasswordEmail" placeholder="••••••••">
                                <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePass()">
                                    <i id="toggleIcon" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold"><i class="bi bi-chat-left-dots me-2"></i>Catatan Internal</label>
                        <textarea class="form-control" name="Catatan" rows="4" placeholder="Contoh: SN Dish, Tanggal Pemasangan, atau Nama Teknisi Lapangan..."></textarea>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg shadow">
                                <i class="bi bi-save me-2"></i> Simpan Perangkat
                            </button>
                            <a href="index.php?halaman=controller" class="btn btn-light-secondary text-muted">Batal & Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
function togglePass() {
    const p = document.getElementById('passInput');
    const i = document.getElementById('toggleIcon');
    if(p.type === 'password') {
        p.type = 'text';
        i.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        p.type = 'password';
        i.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>