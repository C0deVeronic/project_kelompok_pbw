<?php
/**
 * =========================================================================
 * HALAMAN LAPORAN & REKAPITULASI (laporan.php)
 * Memenuhi P7 (Perulangan FOR untuk Render Tabel HTML) & Analisis Data
 * =========================================================================
 */

require_once __DIR__ . '/data/sample.php';
require_once __DIR__ . '/classes/Kendaraan.php';
require_once __DIR__ . '/functions.php';

// Menangani aksi reset data contoh
if (isset($_GET['action']) && $_GET['action'] === 'reset') {
    resetDataSample();
    header('Location: laporan.php?status=reset_success');
    exit;
}

// [P1 & P2] Menangani aksi hapus / check-out kendaraan dari session
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && !empty($_GET['kode'])) {
    $kodeHapus = htmlspecialchars(trim($_GET['kode']));
    $berhasil = hapusKendaraan($kodeHapus);
    if ($berhasil) {
        header('Location: laporan.php?status=hapus_success&kode=' . urlencode($kodeHapus));
    } else {
        header('Location: laporan.php?status=hapus_failed');
    }
    exit;
}

$statusAlert = $_GET['status'] ?? '';
$kodeAlert   = $_GET['kode'] ?? '';

$daftarKendaraan = getDaftarKendaraan();
$keywordPencarian = isset($_GET['q']) ? trim($_GET['q']) : '';

// Filter pencarian jika ada keyword plat nomor
if (!empty($keywordPencarian)) {
    $filteredList = [];
    $totalSemua = count($daftarKendaraan);
    
    // [P7 - PERULANGAN FOR UNTUK SEARCH / FILTERING]
    for ($idx = 0; $idx < $totalSemua; $idx++) {
        // [P4 - Manipulasi String strtoupper & stripos]
        if (stripos($daftarKendaraan[$idx]['plat_nomor'], $keywordPencarian) !== false ||
            stripos($daftarKendaraan[$idx]['kode_tiket'], $keywordPencarian) !== false) {
            $filteredList[] = $daftarKendaraan[$idx];
        }
    }
    $daftarKendaraan = $filteredList;
}

$totalData = count($daftarKendaraan);

// Hitung Statistik Agregat
$grandTotalPendapatan = 0.0;
$totalDurasiJam       = 0;
$countMember          = 0;
$tipeCount            = ['MOTOR' => 0, 'MOBIL' => 0, 'TRUK' => 0];

for ($s = 0; $s < $totalData; $s++) {
    $grandTotalPendapatan += (float)$daftarKendaraan[$s]['total_bayar'];
    $totalDurasiJam       += (int)$daftarKendaraan[$s]['durasi_jam'];
    
    if ($daftarKendaraan[$s]['is_member']) {
        $countMember++;
    }

    $tipeItem = strtoupper($daftarKendaraan[$s]['tipe']);
    if (isset($tipeCount[$tipeItem])) {
        $tipeCount[$tipeItem]++;
    }
}

// [P4 - Operator Aritmatika Pembagian / dan Ternary]
$rataRataDurasi = ($totalData > 0) ? round($totalDurasiJam / $totalData, 1) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi & Laporan Parkir - <?= htmlspecialchars(NAMA_SISTEM); ?></title>
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
                    <li><a href="laporan.php" class="nav-link active"><i class="fa fa-file-lines"></i> Rekap Laporan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">

        <!-- HEADER LAPORAN -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="badge badge-primary" style="margin-bottom: 0.5rem;"><i class="fa fa-chart-line"></i> Laporan Operasional</span>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--dark);">Rekapitulasi Transaksi Parkir</h1>
                <p style="color: var(--text-muted); font-size: 0.92rem;">
                    Daftar seluruh kendaraan terparkir yang dirender dinamis menggunakan <strong>Perulangan FOR (P7)</strong>.
                </p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button onclick="window.print()" class="btn btn-outline btn-sm"><i class="fa fa-print"></i> Cetak PDF / Print</button>
                <a href="index.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input Transaksi</a>
                <a href="laporan.php?action=reset" class="btn btn-outline btn-sm" onclick="return confirm('Kembalikan data ke contoh awal?')">
                    <i class="fa fa-rotate-right"></i> Reset Sample
                </a>
            </div>
        </div>

        <!-- NOTIFIKASI STATUS AKSI -->
        <?php if ($statusAlert === 'hapus_success'): ?>
            <div style="background: var(--success-bg); border: 1.5px solid #a7f3d0; color: #065f46; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <i class="fa-solid fa-circle-check" style="color: var(--success); margin-right: 0.5rem;"></i>
                    <strong>Check-Out Berhasil!</strong> Kendaraan dengan tiket <strong><?= htmlspecialchars($kodeAlert); ?></strong> telah keluar. Slot parkir bertambah 1 kembali.
                </div>
                <a href="laporan.php" style="color: #065f46; text-decoration: none; font-weight: 700;">&times;</a>
            </div>
        <?php elseif ($statusAlert === 'reset_success'): ?>
            <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1e40af; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <i class="fa-solid fa-circle-info" style="color: var(--primary); margin-right: 0.5rem;"></i>
                    Data riwayat parkir berhasil dikembalikan ke data awal contoh.
                </div>
                <a href="laporan.php" style="color: #1e40af; text-decoration: none; font-weight: 700;">&times;</a>
            </div>
        <?php endif; ?>

        <!-- STATISTIK RINGKASAN LAPORAN -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Tiket</h3>
                    <div class="stat-value"><?= (int)$totalData; ?> <span style="font-size: 0.9rem; font-weight: normal;">Tiket</span></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Akumulasi</h3>
                    <div class="stat-value"><?= formatRupiah($grandTotalPendapatan); ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon amber">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="stat-info">
                    <h3>Rata-Rata Durasi</h3>
                    <div class="stat-value"><?= $rataRataDurasi; ?> <span style="font-size: 0.9rem; font-weight: normal;">Jam</span></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div class="stat-info">
                    <h3>Member VIP</h3>
                    <div class="stat-value"><?= (int)$countMember; ?> <span style="font-size: 0.9rem; font-weight: normal;">Pengendara</span></div>
                </div>
            </div>
        </section>

        <!-- FORM PENCARIAN & FILTER PLAT NOMOR -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-body" style="padding: 1rem 1.5rem;">
                <form action="laporan.php" method="GET" style="display: flex; gap: 0.75rem; align-items: center;">
                    <div style="flex: 1; position: relative;">
                        <input 
                            type="text" 
                            name="q" 
                            class="form-control" 
                            placeholder="Cari berdasarkan Plat Nomor atau Kode Tiket (misal: B 1234, PK-B12)..." 
                            value="<?= htmlspecialchars($keywordPencarian); ?>"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-magnifying-glass"></i> Cari Data</button>
                    <?php if (!empty($keywordPencarian)): ?>
                        <a href="laporan.php" class="btn btn-outline"><i class="fa fa-xmark"></i> Bersihkan</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- TABEL DATA KENDARAAN (IMPLEMENTASI P7 - PERULANGAN FOR) -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fa-solid fa-table-list" style="color: var(--primary);"></i> 
                    Daftar Rekap Kendaraan Terparkir
                </h2>
                <span class="badge badge-primary">Output Tabel HTML via FOR Loop (P7)</span>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 45px; text-align: center;">No</th>
                                <th>Kode Tiket</th>
                                <th>Plat Nomor</th>
                                <th>Jenis</th>
                                <th>Zonasi</th>
                                <th>Durasi</th>
                                <th>Status Member</th>
                                <th>Tarif/Jam</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                                <th>Total Bayar</th>
                                <th style="text-align: center; width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalData === 0): ?>
                                <tr>
                                    <td colspan="12" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                                        <i class="fa fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                        Tidak ada data kendaraan ditemukan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                // =============================================================
                                // [P7 - PERULANGAN FOR: Counter & Render Tabel HTML]
                                // Menampilkan array riwayat kendaraan baris demi baris
                                // =============================================================
                                for ($i = 0; $i < $totalData; $i++):
                                    $row = $daftarKendaraan[$i];
                                    $nomorUrut = $i + 1;
                                    
                                    // Ikon kendaraan
                                    $ikon = 'fa-car';
                                    if (strtoupper($row['tipe']) === 'MOTOR') $ikon = 'fa-motorcycle';
                                    if (strtoupper($row['tipe']) === 'TRUK') $ikon = 'fa-truck';
                                ?>
                                    <tr>
                                        <td style="text-align: center; font-weight: 700; color: var(--text-muted);">
                                            <?= $nomorUrut; ?>
                                        </td>
                                        <td>
                                            <span class="code-badge"><?= htmlspecialchars($row['kode_tiket']); ?></span>
                                        </td>
                                        <td>
                                            <strong style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;">
                                                <?= htmlspecialchars($row['plat_nomor']); ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <span style="display: flex; align-items: center; gap: 0.4rem;">
                                                <i class="fa <?= $ikon; ?>" style="color: var(--secondary);"></i>
                                                <?= htmlspecialchars($row['tipe']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge <?= ($row['ganjil_genap'] === 'Genap') ? 'badge-primary' : 'badge-warning'; ?>">
                                                <?= htmlspecialchars($row['ganjil_genap']); ?>
                                            </span>
                                        </td>
                                        <td><?= (int)$row['durasi_jam']; ?> Jam</td>
                                        <td>
                                            <?php if ($row['is_member']): ?>
                                                <span class="badge badge-success"><i class="fa fa-star"></i> VIP</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Reguler</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= formatRupiah((float)$row['tarif_per_jam']); ?></td>
                                        <td><?= formatRupiah((float)$row['subtotal']); ?></td>
                                        <td style="color: <?= $row['diskon'] > 0 ? 'var(--success)' : 'inherit'; ?>;">
                                            <?= $row['diskon'] > 0 ? '- ' . formatRupiah((float)$row['diskon']) : 'Rp 0'; ?>
                                        </td>
                                        <td style="font-weight: 800; color: var(--dark);">
                                            <?= formatRupiah((float)$row['total_bayar']); ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="laporan.php?action=hapus&kode=<?= urlencode($row['kode_tiket']); ?>" 
                                               class="btn btn-outline btn-sm" 
                                               style="color: var(--danger); border-color: #fca5a5; padding: 0.25rem 0.55rem; font-size: 0.78rem;" 
                                               onclick="return confirm('Konfirmasi kendaraan keluar (Check-Out) untuk tiket <?= htmlspecialchars($row['kode_tiket']); ?>?\nSlot parkir akan dikosongkan kembali.')">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if ($totalData > 0): ?>
                            <tfoot>
                                <tr style="background: #f8fafc; font-weight: 800;">
                                    <td colspan="10" style="text-align: right; padding: 1rem;">GRAND TOTAL PENERIMAAN:</td>
                                    <td colspan="2" style="padding: 1rem; color: var(--primary); font-size: 1.05rem;">
                                        <?= formatRupiah($grandTotalPendapatan); ?>
                                    </td>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; <?= date('Y'); ?> <strong><?= htmlspecialchars(NAMA_SISTEM); ?></strong> • <?= INSTITUSI; ?></p>
        <p style="font-size: 0.78rem; margin-top: 0.25rem;">Dikembangkan untuk Tugas Proyek Integrasi PBW Pertemuan 1–7</p>
    </footer>

</body>
</html>
