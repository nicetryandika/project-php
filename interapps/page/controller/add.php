<?php
/**
 * Halaman Tambah Data Controller Starlink - InterApps Indonesian Deep Purple Style
 */
require_once "./function/nocodb.php";
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --bg-soft: #f4f7ff;
        --deep-purple: #0f0a1e; /* Warna deep purple login Anda */
        --purple-primary: #7c4dff; /* Warna ungu utama login Anda */
        --purple-hover: #4527a0;
        --text-main: #1a1a1a;
        --text-muted: #666;
    }

    body {
        background-color: var(--bg-soft);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* Header Design */
    .form-header {
        margin-bottom: 30px;
        border-left: 5px solid var(--purple-primary);
        padding-left: 20px;
    }

    .form-header h2 {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--deep-purple);
        margin-bottom: 5px;
    }

    .form-header p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Card Styling */
    .main-card {
        background: #ffffff;
        border-radius: 30px;
        border: none;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(15, 10, 30, 0.05);
    }

    /* Group Label */
    .group-title {
        font-weight: 800;
        font-size: 0.75rem;
        color: var(--purple-primary);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .group-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    /* Input Field Styling - Mengikuti gaya login.php */
    .input-box {
        margin-bottom: 20px;
    }

    .input-box label {
        display: block;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 8px;
        color: var(--deep-purple);
    }

    .custom-input {
        background: #f8faff !important;
        border: 2px solid transparent !important;
        border-radius: 15px !important;
        padding: 14px 18px !important;
        font-weight: 600 !important;
        color: var(--deep-purple) !important;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        background: #fff !important;
        border-color: var(--purple-primary) !important;
        box-shadow: 0 10px 20px rgba(124, 77, 255, 0.1) !important;
        outline: none;
        transform: translateY(-2px);
    }

    /* Khusus untuk area kredensial portal */
    .portal-box {
        background: #fcfaff;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 25px;
        margin-top: 10px;
    }

    /* Buttons */
    .btn-save {
        background: linear-gradient(135deg, var(--purple-primary) 0%, var(--purple-hover) 100%);
        color: white;
        border: none;
        padding: 16px 35px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 10px 25px rgba(124, 77, 255, 0.3);
        transition: all 0.3s;
        width: 100%;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(124, 77, 255, 0.4);
        opacity: 0.95;
    }

    .btn-back {
        background: transparent;
        color: var(--text-muted);
        border: none;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        color: var(--purple-primary);
    }

    /* Alert Style - Small Info */
    .info-alert {
        background: #f0ebff;
        border-radius: 12px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--purple-primary);
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 30px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Tambah Perangkat</h2>
        <p>Silakan lengkapi data teknis Starlink di bawah ini dengan benar.</p>
    </div>

    <form action="page/controller/process_add.php" method="POST">
        <div class="main-card">
            
            <div class="info-alert">
                <i class="bi bi-info-circle-fill"></i>
                Data yang Anda masukkan akan sinkron secara otomatis dengan database pusat.
            </div>

            <div class="group-title">Identitas Perangkat</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Kode Kontroler</label>
                        <input type="text" name="CodeController" class="form-control custom-input" placeholder="Misal: ST-01" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Nama Perangkat</label>
                        <input type="text" name="NamaController" class="form-control custom-input" placeholder="Misal: Starlink Kantor Pusat" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Model Hardware</label>
                        <select name="VersiHardware" class="form-select custom-input">
                            <option value="" disabled selected>Pilih Model</option>
                            <option value="Gen 2">Gen 2 (Actuated)</option>
                            <option value="Gen 3">Gen 3 (Standard)</option>
                            <option value="High Performance">High Performance</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Nomor Kit (Kit Number)</label>
                        <input type="text" name="KitNumber" class="form-control custom-input" placeholder="KIT-XXXXXX">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <label>Nomor Seri (Serial Number)</label>
                        <input type="text" name="SerialNumber" class="form-control custom-input" placeholder="SN-XXXXXX">
                    </div>
                </div>
            </div>

            <div class="group-title" style="margin-top: 20px;">Konfigurasi Jaringan & Status</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Alamat IP (IP Address)</label>
                        <input type="text" name="IPAddress" class="form-control custom-input" placeholder="192.168.1.x">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Tanggal Aktivasi</label>
                        <input type="date" name="TglAktivasi" class="form-control custom-input">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Status Operasional</label>
                        <select name="StatusAktif" class="form-select custom-input">
                            <option value="Aktif">Aktif / Online</option>
                            <option value="Non-Aktif">Non-Aktif / Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box">
                        <label>Paket Layanan</label>
                        <select name="PaketLayanan" class="form-select custom-input">
                            <option value="Standard">Standard</option>
                            <option value="Priority">Priority</option>
                            <option value="Mobile">Mobile Roam</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-box">
                <label>Lokasi Penempatan</label>
                <input type="text" name="LokasiPemasangan" class="form-control custom-input" placeholder="Contoh: Gedung A Lantai 3">
            </div>

            <div class="group-title" style="margin-top: 20px;">Akses Akun Portal</div>
                <div class="portal-box">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold mb-1 d-block">Nama Pemilik Akun</label>
                            <input type="text" name="NamaAkun" class="form-control custom-input" placeholder="Nama Lengkap Pemilik">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold mb-1 d-block">Email Terdaftar</label>
                            <input type="email" name="EmailAkun" class="form-control custom-input" placeholder="email@perusahaan.com">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1 d-block">Username Portal</label>
                            <input type="text" name="UsernameEmail" class="form-control custom-input">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1 d-block">Password Portal</label>
                            <input type="password" name="PasswordEmail" class="form-control custom-input">
                        </div>
                    </div>
                </div>

            <div class="input-box mt-4">
                <label>Catatan Tambahan</label>
                <textarea name="Catatan" class="form-control custom-input" rows="3" placeholder="Opsional..."></textarea>
            </div>

            <div class="row mt-5 align-items-center">
                <div class="col-md-4">
                    <a href="index.php?halaman=controller" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
                <div class="col-md-8 text-end">
                    <button type="submit" name="save" class="btn-save">
                        Simpan Data<i class="bi bi-plus-lg ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    
    <!-- <div class="text-center mt-4">
        <p class="small text-muted">© 2026 InterApps System — Monitoring Starlink Terpadu</p>
    </div> -->
</div>