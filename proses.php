<?php
/**
 * =========================================================================
 * HALAMAN PEMROSESAN & TIKET DIGITAL (proses.php)
 * Memenuhi P1 (Request Handling), P2 (OOP Object), P5 (WHILE), P6 (DO-WHILE)
 * =========================================================================
 */

require_once __DIR__ . '/data/sample.php';
require_once __DIR__ . '/classes/Kendaraan.php';
require_once __DIR__ . '/functions.php';

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');
$errors = [];
$kendaraan = null;

if ($isPost) {
    // [P4 - MANIPULASI STRING & VALIDASI]
    $validasi = validasiInputParkir($_POST);

    if (!$validasi['valid']) {
        $errors = $validasi['errors'];
    } else {
        $dataClean = $validasi['cleaned'];

        // [P3 - TYPE CASTING / KONVERSI EKSPLISIT]
        $platNomor = (string)$dataClean['plat_nomor'];
        $tipe      = (string)$dataClean['tipe'];
        $durasiJam = (int)$dataClean['durasi_jam'];
        $isMember  = (bool)$dataClean['is_member'];

        // =================================================================
        // [P2 - INSTANSIASI OBJECT OOP DARI KELAS Kendaraan]
        // =================================================================
        $kendaraan = new Kendaraan($platNomor, $tipe, $durasiJam, $isMember);

        // Simpan ke riwayat session untuk pelaporan di laporan.php
        simpanKendaraanBaru($kendaraan->toArray());
    }
} else {
    // Jika diakses langsung tanpa POST, buat objek contoh demo
    $kendaraan = new Kendaraan('B 7777 PRO', 'MOBIL', 3, true);
}

// =========================================================================
// [P5 - EKSEKUSI PERULANGAN WHILE]
// Simulasi pemrosesan antrean kendaraan di gerbang
// =========================================================================
$antreanSimulasi = rand(2, 4);
$logWhile = simulasiAntreanWhile($antreanSimulasi);

// =========================================================================
// [P6 - EKSEKUSI PERULANGAN DO-WHILE]
// Simulasi pemeriksaan checklist tiket keluar minimal satu kali
// =========================================================================
$logDoWhile = [];
if ($kendaraan !== null) {
    $logDoWhile = simulasiPemeriksaanDoWhile($kendaraan->getKodeTiket(), $kendaraan->getPlatNomor());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Transaksi & Karcis - <?= htmlspecialchars(NAMA_SISTEM); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- NAVBAR -->
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
                    <li><a href="index.php" class="nav-link"><i class="fa fa-dashboard"></i> Dashboard & Input</a></li>
                    <li><a href="laporan.php" class="nav-link"><i class="fa fa-file-lines"></i> Rekap Laporan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">

        <!-- JIKA TERDAPAT ERROR VALIDASI -->
        <?php if (!empty($errors)): ?>
            <div class="card" style="border-color: var(--danger); margin-bottom: 2rem;">
                <div class="card-header" style="background: var(--danger-bg); color: var(--danger);">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> Gagal Memproses Data</h2>
                </div>
                <div class="card-body">
                    <p style="margin-bottom: 0.75rem;">Harap perbaiki data input berikut:</p>
                    <ul style="padding-left: 1.5rem; color: var(--danger);">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div style="margin-top: 1.5rem;">
                        <a href="index.php" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Kembali ke Form</a>
                    </div>
                </div>
            </div>
        <?php else: ?>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--dark);">
                        <i class="fa-solid fa-circle-check" style="color: var(--success);"></i> Transaksi Berhasil Diproses
                    </h1>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        Data telah dihitung menggunakan Class OOP & Fungsi Prosedural terintegrasi.
                    </p>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="index.php" class="btn btn-outline btn-sm"><i class="fa fa-plus"></i> Input Baru</a>
                    <a href="laporan.php" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Lihat Laporan</a>
                    <button onclick="window.print()" class="btn btn-outline btn-sm"><i class="fa fa-print"></i> Cetak Struk</button>
                </div>
            </div>

            <div class="content-grid">
                <!-- STRUK / TIKET PARKIR RESMI -->
                <div class="ticket-receipt">
                    <div class="ticket-header">
                        <img src="assets/images/car-parking-sign-7345139_1280.jpg" alt="Logo" style="width: 44px; height: 44px; border-radius: 8px; margin-bottom: 0.6rem; object-fit: cover; border: 2px solid rgba(255,255,255,0.4); display: inline-block;">
                        <h2><?= htmlspecialchars(NAMA_SISTEM); ?></h2>
                        <p>KARCIS PARKIR RESMI & BUKTI PEMBAYARAN</p>
                        <div style="margin-top: 0.5rem;">
                            <span class="badge badge-success"><?= htmlspecialchars($kendaraan->getKodeTiket()); ?></span>
                        </div>
                    </div>

                    <div class="ticket-body">
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Waktu Masuk</span>
                            <strong><?= htmlspecialchars($kendaraan->getWaktuMasuk()); ?></strong>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Plat Nomor</span>
                            <strong style="font-size: 1.05rem; letter-spacing: 0.05em;"><?= htmlspecialchars($kendaraan->getPlatNomor()); ?></strong>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Jenis Kendaraan</span>
                            <span><strong><?= htmlspecialchars($kendaraan->getTipe()); ?></strong></span>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Zonasi Plat (Modulus)</span>
                            <span class="badge <?= $kendaraan->cekGanjilGenap() === 'Genap' ? 'badge-primary' : 'badge-warning'; ?>">
                                <?= $kendaraan->cekGanjilGenap(); ?>
                            </span>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Status Keanggotaan</span>
                            <?= $kendaraan->getStatusMemberBadge(); ?>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Durasi Parkir</span>
                            <strong><?= $kendaraan->getDurasiJam(); ?> Jam</strong>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Tarif Dasar / Jam</span>
                            <span><?= formatRupiah($kendaraan->getTarifPerJam()); ?></span>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Subtotal Durasi</span>
                            <span><?= formatRupiah($kendaraan->hitungSubtotal()); ?></span>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Diskon Member VIP (10%)</span>
                            <span style="color: var(--success);">- <?= formatRupiah($kendaraan->hitungDiskon()); ?></span>
                        </div>
                        <div class="ticket-row">
                            <span style="color: var(--text-muted);">Biaya Administrasi Sistem</span>
                            <span>+ <?= formatRupiah($kendaraan->getBiayaAdmin()); ?></span>
                        </div>

                        <!-- TOTAL BAYAR -->
                        <div class="ticket-row total-row">
                            <span>TOTAL BAYAR</span>
                            <span><?= formatRupiah($kendaraan->hitungTotalBayar()); ?></span>
                        </div>

                        <!-- BARCODE SIMULASI -->
                        <div class="barcode-sim">
                            <div class="barcode-lines">||| | |||| | |||||| || | ||</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.35rem;">
                                <?= htmlspecialchars($kendaraan->getKodeTiket()); ?>
                            </div>
                        </div>

                        <div style="text-align: center; font-size: 0.75rem; color: var(--text-muted); margin-top: 1rem;">
                            Simpan karcis ini dengan baik. Kehilangan karcis dikenakan denda sesuai regulasi.
                        </div>
                    </div>
                </div>

                <!-- IMPLEMENTASI STRUKTUR KONTROL LOOP (P5 & P6) -->
                <div>
                    <!-- CARD IMPLEMENTASI WHILE (P5) -->
                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div class="card-header">
                            <h2>
                                <i class="fa-solid fa-arrows-spin" style="color: var(--primary);"></i> 
                                Implementasi P5: Loop WHILE
                            </h2>
                            <span class="badge badge-primary">Kondisi: Antrean > 0</span>
                        </div>
                        <div class="card-body">
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                Mensimulasikan pemrosesan sensor gate kendaraan secara berurutan selama antrean masih bersisa:
                            </p>
                            <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.85rem; font-size: 0.82rem; font-family: 'JetBrains Mono', monospace;">
                                <?php foreach ($logWhile as $item): ?>
                                    <div style="margin-bottom: 0.4rem; padding-bottom: 0.4rem; border-bottom: 1px dashed #e2e8f0;">
                                        <span style="color: var(--primary); font-weight: 700;">[Antrean #<?= $item['urutan']; ?>]</span> 
                                        <?= htmlspecialchars($item['status']); ?> 
                                        <span style="color: var(--text-muted);">(Scan: <?= $item['waktu_scan']; ?>, Sisa antrean: <?= $item['sisa_antrean']; ?>)</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span class="form-hint" style="margin-top: 0.5rem;">
                                Bukti kode: <span class="code-badge">functions.php:L129 (simulasiAntreanWhile)</span>
                            </span>
                        </div>
                    </div>

                    <!-- CARD IMPLEMENTASI DO-WHILE (P6) -->
                    <div class="card">
                        <div class="card-header">
                            <h2>
                                <i class="fa-solid fa-shield-halved" style="color: var(--success);"></i> 
                                Implementasi P6: Loop DO-WHILE
                            </h2>
                            <span class="badge badge-success">Min 1x Eksekusi</span>
                        </div>
                        <div class="card-body">
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                Menjamin checklist verifikasi gate keluar dieksekusi <strong>minimal 1 kali</strong> sebelum evaluasi kondisi:
                            </p>
                            <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.85rem; font-size: 0.82rem; font-family: 'JetBrains Mono', monospace;">
                                <?php foreach ($logDoWhile as $audit): ?>
                                    <div style="margin-bottom: 0.4rem; padding-bottom: 0.4rem; border-bottom: 1px dashed #e2e8f0; display: flex; justify-content: space-between;">
                                        <span>
                                            <strong style="color: var(--success);"><?= htmlspecialchars($audit['keterangan']); ?></strong>
                                        </span>
                                        <span style="color: var(--secondary); font-size: 0.75rem;">[<?= $audit['waktu']; ?>]</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span class="form-hint" style="margin-top: 0.5rem;">
                                Bukti kode: <span class="code-badge">functions.php:L166 (simulasiPemeriksaanDoWhile)</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; <?= date('Y'); ?> <strong><?= htmlspecialchars(NAMA_SISTEM); ?></strong> • <?= INSTITUSI; ?></p>
        <p style="font-size: 0.78rem; margin-top: 0.25rem;">Dikembangkan untuk Tugas Proyek Integrasi PBW Pertemuan 1–7</p>
    </footer>

</body>
</html>
