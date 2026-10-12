<?php
/**
 * =========================================================================
 * HALAMAN UTAMA & INPUT (index.php)
 * Memenuhi Kompetensi P1 (Paradigma PHP, Sintaks Dasar, Web Dinamis)
 * =========================================================================
 */

// Memanggil dependensi data, fungsi, dan kelas
require_once __DIR__ . '/data/sample.php';
require_once __DIR__ . '/classes/Kendaraan.php';
require_once __DIR__ . '/functions.php';

// Ambil data kendaraan dari session
$daftarKendaraan = getDaftarKendaraan();
$totalKendaraan  = count($daftarKendaraan);
$slotTotal       = KAPASITAS_SLOT_TOTAL; // [P3] Konstanta
$slotTerisi      = min($totalKendaraan, $slotTotal);
$slotSisa        = $slotTotal - $slotTerisi; // [P4] Operator Aritmatika -

// Hitung total estimasi penerimaan
$totalPenerimaan = 0.0;
for ($k = 0; $k < $totalKendaraan; $k++) {
    $totalPenerimaan += (float)$daftarKendaraan[$k]['total_bayar']; // [P3] Type casting
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(NAMA_SISTEM); ?> - Sistem Manajemen Parkir</title>
    <!-- CSS Utama -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- NAVBAR NAVIGASI UTAMA -->
    <header class="navbar">
        <div class="nav-container">
            <a href="index.php" class="brand">
                <div class="brand-icon">
                    <img src="assets/images/car-parking-sign-7345139_1280.jpg" alt="Logo SmartPark">
                </div>
                <div>
                    <div>SmartPark System</div>
                    <span class="brand-subtitle">Proyek Integrasi P1–P7</span>
                </div>
            </a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link active"><i class="fa fa-dashboard"></i> Dashboard & Input</a></li>
                    <li><a href="laporan.php" class="nav-link"><i class="fa fa-file-lines"></i> Rekap Laporan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <!-- HEADER HALAMAN -->
        <div class="page-header">
            <span class="badge-tag"><i class="fa fa-code"></i> PBW Pertemuan 1–7</span>
            <h1><?= htmlspecialchars(NAMA_SISTEM); ?></h1>
            <p>Aplikasi web dinamis PHP untuk manajemen operasional parkir, kalkulasi tarif berbasis durasi & jenis kendaraan, simulasi antrean loop, serta pelaporan terintegrasi.</p>
        </div>

        <!-- STATS COUNTER CARDS -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Kapasitas</h3>
                    <div class="stat-value"><?= (int)$slotTotal; ?> <span style="font-size: 0.9rem; font-weight: normal;">Slot</span></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="fa-solid fa-car-side"></i>
                </div>
                <div class="stat-info">
                    <h3>Kendaraan Terparkir</h3>
                    <div class="stat-value"><?= (int)$slotTerisi; ?> <span style="font-size: 0.9rem; font-weight: normal;">Unit</span></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Slot Tersedia</h3>
                    <div class="stat-value"><?= (int)$slotSisa; ?> <span style="font-size: 0.9rem; font-weight: normal;">Slot</span></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Pendapatan</h3>
                    <div class="stat-value"><?= formatRupiah($totalPenerimaan); ?></div>
                </div>
            </div>
        </section>

        <!-- KONTEN UTAMA: FORM INPUT DAN VISUALISASI SLOT -->
        <div class="content-grid">
            <!-- FORM INPUT KENDARAAN MASUK/KELUAR -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fa-solid fa-ticket"></i> Input Data Tiket Parkir</h2>
                    <span class="badge badge-primary">Form Transaksi</span>
                </div>
                <div class="card-body">
                    <form action="proses.php" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="plat_nomor">
                                Plat Nomor Kendaraan <span class="req">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="plat_nomor" 
                                name="plat_nomor" 
                                class="form-control" 
                                placeholder="Contoh: B 1234 ABC" 
                                required 
                                autocomplete="off"
                            >
                            <span class="form-hint">Format huruf kapital & angka standar Indonesia (3 - 12 karakter).</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tipe">
                                Jenis Kendaraan <span class="req">*</span>
                            </label>
                            <select id="tipe" name="tipe" class="form-control" required>
                                <option value="">-- Pilih Jenis Kendaraan --</option>
                                <option value="MOTOR">Sepeda Motor (Rp 2.000 / jam)</option>
                                <option value="MOBIL" selected>Mobil Pribadi (Rp 5.000 / jam)</option>
                                <option value="TRUK">Truk / Bus (Rp 10.000 / jam)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="durasi_jam">
                                Estimasi Durasi Parkir (Jam) <span class="req">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="durasi_jam" 
                                name="durasi_jam" 
                                class="form-control" 
                                min="1" 
                                max="168" 
                                value="2" 
                                required
                            >
                            <span class="form-hint">Jam ke-1 tarif flat penuh, jam ke-2 dst diskon progresif 20%.</span>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-custom">
                                <input type="checkbox" name="is_member" value="1">
                                <div>
                                    <strong>Member Parkir VIP (Langganan)</strong>
                                    <div class="form-hint" style="margin-top: 0;">Mendapatkan potongan diskon 10% dari subtotal tarif.</div>
                                </div>
                            </label>
                        </div>

                        <div class="form-group" style="margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa-solid fa-calculator"></i> Proses Transaksi & Cetak Tiket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- VISUALISASI DENAH SLOT PARKIR (IMPLEMENTASI FOR P7) -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fa-solid fa-map-location-dot"></i> Visualisasi Denah Parkir</h2>
                    <span class="badge badge-success">Blok A - D</span>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1rem;">
                        Denah slot parkir 2D yang digenerate otomatis menggunakan <strong>Nested FOR Loop (P7)</strong>:
                    </p>
                    
                    <!-- Render HTML denah menggunakan nested FOR loop -->
                    <?= renderSlotVisualFor(4, 6, $slotTerisi); ?>

                    <div style="display: flex; gap: 1.5rem; justify-content: center; margin-top: 1.25rem; font-size: 0.82rem;">
                        <span style="display: flex; align-items: center; gap: 0.4rem;">
                            <span style="width: 12px; height: 12px; background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 3px;"></span>
                            Tersedia (Kosong)
                        </span>
                        <span style="display: flex; align-items: center; gap: 0.4rem;">
                            <span style="width: 12px; height: 12px; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 3px;"></span>
                            Terisi Kendaraan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHECKLIST PEMENUHAN MATRIKS KOMPETENSI P1 - P7 -->
        <section class="matrix-container">
            <div class="matrix-header">
                <div>
                    <h3 style="font-weight: 800; font-size: 1.15rem; color: var(--dark);">
                        <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Checklist Matriks Kompetensi Wajib (P1–P7)
                    </h3>
                    <p style="font-size: 0.82rem; color: var(--text-muted);">
                        Panduan pembuktian baris kode untuk presentasi dan penilaian dosen Ari Wibowo, S.Kom., M.Kom
                    </p>
                </div>
                <span class="badge badge-success">100% Terpenuhi</span>
            </div>

            <div class="data-table-container">
                <table class="matrix-table">
                    <thead>
                        <tr>
                            <th style="width: 110px;">Pertemuan</th>
                            <th>Materi Pokok</th>
                            <th>Bukti Implementasi di Kode</th>
                            <th style="width: 250px;">Lokasi File & Baris</th>
                            <th style="width: 90px; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>P1</strong></td>
                            <td>Paradigma PHP & Sintaks Dasar</td>
                            <td>Struktur file PHP, web dinamis di localhost/XAMPP, form handling POST/GET.</td>
                            <td><span class="code-badge">index.php</span>, <span class="code-badge">proses.php</span></td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P2</strong></td>
                            <td>Procedural & OOP</td>
                            <td>Fungsi prosedural (hitungBiaya, formatRupiah, hapusKendaraan) + 1 Class OOP dengan constructor & object.</td>
                            <td>
                                <span class="code-badge">functions.php:L18, L279</span><br>
                                <span class="code-badge">classes/Kendaraan.php:L11</span>
                            </td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P3</strong></td>
                            <td>Variabel & Tipe Data</td>
                            <td>5 tipe data (String, Int, Float, Bool, Array) + Konstanta (define, const) + Konversi Type Casting.</td>
                            <td>
                                <span class="code-badge">data/sample.php:L15-L22</span> (Konstanta)<br>
                                <span class="code-badge">functions.php:L21-L24</span> (Casting)
                            </td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P4</strong></td>
                            <td>Operator & Manipulasi String</td>
                            <td>Operator lengkap (+, -, *, /, %, ==, &&, ||, ternary) + 6 teknik manipulasi string (trim, strtoupper, strlen, substr, str_replace, htmlspecialchars).</td>
                            <td>
                                <span class="code-badge">functions.php:L32-L100</span><br>
                                <span class="code-badge">classes/Kendaraan.php:L105-L135</span>
                            </td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P5</strong></td>
                            <td>Perulangan WHILE</td>
                            <td>Loop berbasis kondisi (simulasi pengosongan/pemrosesan antrean gate kendaraan).</td>
                            <td><span class="code-badge">functions.php:L129-L150</span> (simulasiAntreanWhile)</td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P6</strong></td>
                            <td>Perulangan DO-WHILE</td>
                            <td>Minimal 1 kali eksekusi (simulasi checklist audit sensor tiket gerbang keluar).</td>
                            <td><span class="code-badge">functions.php:L166-L195</span> (simulasiPemeriksaanDoWhile)</td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                        <tr>
                            <td><strong>P7</strong></td>
                            <td>Perulangan FOR</td>
                            <td>Perulangan counter, nested loop render denah slot, tabel HTML laporan, & pencarian indeks check-out.</td>
                            <td>
                                <span class="code-badge">functions.php:L207-L280</span><br>
                                <span class="code-badge">laporan.php:L236-L286</span>
                            </td>
                            <td style="text-align: center;"><span class="badge badge-success">Wajib</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- FOOTER APLIKASI -->
    <footer class="footer">
        <p>&copy; <?= date('Y'); ?> <strong><?= htmlspecialchars(NAMA_SISTEM); ?></strong> • <?= INSTITUSI; ?></p>
        <p style="font-size: 0.78rem; margin-top: 0.25rem;">Dikembangkan untuk Tugas Proyek Integrasi PBW Pertemuan 1–7</p>
    </footer>

</body>
</html>
