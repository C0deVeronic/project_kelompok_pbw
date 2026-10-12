<?php
/**
 * =========================================================================
 * FUNGSI-FUNGSI PROSEDURAL (functions.php)
 * Memenuhi Kompetensi P2, P3, P4, P5, P6, P7
 * =========================================================================
 * Berisi fungsi-fungsi bisnis prosedural yang dipisahkan dari tampilan UI.
 */

// =========================================================================
// [P2 - FUNCTION PROSEDURAL 1 & P4 - OPERATOR LENGKAP]
// =========================================================================
/**
 * Menghitung rincian biaya parkir secara prosedural
 * 
 * @param string $tipe       Jenis kendaraan ('MOTOR', 'MOBIL', 'TRUK')
 * @param int    $durasi     Lama parkir dalam jam
 * @param bool   $isMember   Status keanggotaan
 * @return array             Rincian perhitungan biaya lengkap
 */
function hitungBiayaParkir(string $tipe, int $durasi, bool $isMember = false): array {
    // [P3 - TYPE CASTING / KONVERSI TIPE DATA]
    $durasiClean = (int)$durasi;
    $tipeClean   = (string)strtoupper(trim($tipe));
    $memberClean = (bool)$isMember;

    // Tentukan tarif dasar per jam
    $tarifDasar = 3000.0;
    if ($tipeClean === 'MOTOR') {
        $tarifDasar = 2000.0;
    } elseif ($tipeClean === 'MOBIL') {
        $tarifDasar = 5000.0;
    } elseif ($tipeClean === 'TRUK' || $tipeClean === 'BUS') {
        $tarifDasar = 10000.0;
    }

    // [P4 - OPERATOR ARITMATIKA: * , + , -]
    // 1 jam pertama tarif penuh, jam berikutnya diskon 20%
    if ($durasiClean <= 1) {
        $subtotal = $tarifDasar;
    } else {
        $jamBerikutnya = $durasiClean - 1;
        $tarifLanjutan  = $tarifDasar * 0.8;
        $subtotal       = $tarifDasar + ($jamBerikutnya * $tarifLanjutan);
    }

    // [P4 - OPERATOR TERNARY & LOGIKA]
    // Member mendapat potongan 10%
    $persenDiskon = ($memberClean === true) ? 0.10 : 0.0;
    $diskonNominal = (float)($subtotal * $persenDiskon);

    $biayaAdmin = 1000.0; // Biaya cetak karcis / sistem

    // [P4 - OPERATOR ARITMATIKA: - dan +]
    $totalBayar = ($subtotal - $diskonNominal) + $biayaAdmin;

    return [
        'tipe'          => $tipeClean,
        'durasi'        => $durasiClean,
        'tarif_per_jam' => (float)$tarifDasar,
        'subtotal'      => (float)$subtotal,
        'diskon'        => (float)$diskonNominal,
        'biaya_admin'   => (float)$biayaAdmin,
        'total_bayar'   => (float)$totalBayar,
        'is_member'     => $memberClean
    ];
}

// =========================================================================
// [P2 - FUNCTION PROSEDURAL 2 & FORMATTING]
// =========================================================================
/**
 * Memformat angka float/int menjadi format Rupiah Indonesia
 */
function formatRupiah(float $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// =========================================================================
// [P4 - MANIPULASI STRING: Minimal 4 Teknik String]
// Teknik: trim, strtoupper, strlen, substr, str_replace, htmlspecialchars
// =========================================================================

/**
 * Teknik String 1, 2, 3: Membersihkan, merapikan, dan standarisasi plat nomor
 */
function normalisasiPlatNomor(string $plat): string {
    // [Teknik String 1]: trim() menghapus spasi di awal dan akhir
    $hasil = trim($plat);

    // [Teknik String 2]: strtoupper() mengubah menjadi huruf kapital semua
    $hasil = strtoupper($hasil);

    // [Teknik String 3]: str_replace() atau regex merapikan spasi berlebih
    $hasil = preg_replace('/\s+/', ' ', $hasil);

    return $hasil;
}

/**
 * Teknik String 4, 5, 6: Validasi input, panjang teks (strlen), keamanan (htmlspecialchars)
 */
function validasiInputParkir(array $data): array {
    $errors = [];

    // [Teknik String 4]: htmlspecialchars() untuk mencegah serangan XSS
    $plat   = isset($data['plat_nomor']) ? htmlspecialchars(trim($data['plat_nomor'])) : '';
    $tipe   = isset($data['tipe']) ? htmlspecialchars(trim($data['tipe'])) : '';
    $durasi = isset($data['durasi_jam']) ? (int)$data['durasi_jam'] : 0;

    // [Teknik String 5]: strlen() mengecek panjang karakter nomor plat
    $panjangPlat = strlen($plat);
    if ($panjangPlat < 3 || $panjangPlat > 12) {
        $errors[] = "Panjang Plat Nomor tidak valid (antara 3 - 12 karakter). Saat ini: $panjangPlat karakter.";
    }

    // [Teknik String 6]: substr() mengecek wilayah kode plat nomor
    $kodeWilayah = strtoupper(substr($plat, 0, 1));
    if (!ctype_alpha($kodeWilayah)) {
        $errors[] = "Huruf pertama plat nomor harus berupa alfabet wilayah (contoh: B, D, F, AB).";
    }

    // [P4 - Operator Perbandingan & Logika]
    if ($durasi <= 0 || $durasi > 720) {
        $errors[] = "Durasi parkir harus di antara 1 hingga 720 jam (30 hari).";
    }

    $daftarTipeValid = ['MOTOR', 'MOBIL', 'TRUK', 'BUS'];
    if (!in_array(strtoupper($tipe), $daftarTipeValid)) {
        $errors[] = "Tipe kendaraan harus salah satu dari: Motor, Mobil, atau Truk/Bus.";
    }

    return [
        'valid'   => empty($errors),
        'errors'  => $errors,
        'cleaned' => [
            'plat_nomor' => normalisasiPlatNomor($plat),
            'tipe'       => strtoupper($tipe),
            'durasi_jam' => $durasi,
            'is_member'  => !empty($data['is_member'])
        ]
    ];
}

// =========================================================================
// [P5 - STRUKTUR KONTROL: WHILE (Loop berbasis kondisi)]
// =========================================================================
/**
 * Mensimulasikan pemrosesan antrean kendaraan di gerbang masuk/keluar
 * Menggunakan perulangan WHILE berbasis kondisi (antrean > 0)
 * 
 * @param int $jumlahAntrean Jumlah kendaraan dalam antrean
 * @return array Log tahapan pemrosesan
 */
function simulasiAntreanWhile(int $jumlahAntrean): array {
    $logProses = [];
    $antreanSisa = $jumlahAntrean;
    $nomorUrut = 1;

    // [P5 - IMPLEMENTASI WHILE]
    // Berjalan terus selama kondisi ($antreanSisa > 0) terpenuhi
    while ($antreanSisa > 0) {
        $waktuProsesDetik = rand(2, 5); // Simulasi waktu palang pintu terbuka
        $logProses[] = [
            'urutan'     => $nomorUrut,
            'status'     => "Kendaraan antrean ke-{$nomorUrut} berhasil melewati gate sensor.",
            'waktu_scan' => "{$waktuProsesDetik} detik",
            'sisa_antrean' => $antreanSisa - 1
        ];

        // Decrement kondisi
        $antreanSisa--;
        $nomorUrut++;
    }

    return $logProses;
}

// =========================================================================
// [P6 - STRUKTUR KONTROL: DO-WHILE (Minimal satu kali eksekusi)]
// =========================================================================
/**
 * Mensimulasikan checklist verifikasi keamanan gerbang keluar
 * Menggunakan DO-WHILE untuk menjamin proses verifikasi dijalankan MINIMAL 1 KALI
 * 
 * @param string $kodeTiket  Kode tiket yang sedang diperiksa
 * @param string $platNomor  Plat kendaraan
 * @return array Hasil checklist audit keluar
 */
function simulasiPemeriksaanDoWhile(string $kodeTiket, string $platNomor): array {
    $hasilAudit = [];
    $langkah = 0;
    $statusVerifikasi = false;

    $daftarItemPemeriksaan = [
        "1. Scan Optical Barcode Karcis ($kodeTiket)",
        "2. Pencocokan Plat Kamera ANPR terhadap Database ($platNomor)",
        "3. Konfirmasi Status Pembayaran & Pembukaan Palang Gate"
    ];

    $totalLangkah = count($daftarItemPemeriksaan);

    // [P6 - IMPLEMENTASI DO-WHILE]
    // Blok do akan selalu dieksekusi minimal 1 kali sebelum kondisi diperiksa
    do {
        $deskripsi = $daftarItemPemeriksaan[$langkah];
        $hasilAudit[] = [
            'tahap'       => $langkah + 1,
            'keterangan'  => $deskripsi,
            'status'      => 'TERVERIFIKASI ✓',
            'waktu'       => date('H:i:s')
        ];

        $langkah++;

        // Kondisi selesai jika seluruh langkah telah dilewati
        if ($langkah >= $totalLangkah) {
            $statusVerifikasi = true;
        }

    } while (!$statusVerifikasi && $langkah < $totalLangkah);

    return $hasilAudit;
}

// =========================================================================
// [P7 - STRUKTUR KONTROL: FOR (Counter, Nested Loop, HTML Grid/Table)]
// =========================================================================
/**
 * Merender visualisasi Denah Slot Parkir 2D menggunakan NESTED FOR LOOP
 * Memenuhi P7: Counter, nested loop, dan output elemen HTML
 * 
 * @param int $totalSlot Jumlah total slot (misal: 24)
 * @param int $terisi    Jumlah slot yang saat ini terisi
 * @return string HTML grid slot parkir
 */
function renderSlotVisualFor(int $totalBaris = 4, int $kolomPerBaris = 6, int $terisi = 5): string {
    $html = '<div class="parking-grid-wrapper">';
    $nomorSlot = 1;

    // [P7 - NESTED FOR LOOP: Loop Luar untuk Baris Denah]
    for ($baris = 1; $baris <= $totalBaris; $baris++) {
        $html .= "<div class='parking-row'><div class='row-label'>Blok " . chr(64 + $baris) . "</div><div class='row-slots'>";
        
        // [P7 - Loop Dalam untuk Kolom Tiap Baris]
        for ($kolom = 1; $kolom <= $kolomPerBaris; $kolom++) {
            $isTerisi = ($nomorSlot <= $terisi);
            $kelasCss = $isTerisi ? 'slot-occupied' : 'slot-available';
            $statusTeks = $isTerisi ? 'TERISI' : 'KOSONG';
            $ikon = $isTerisi ? '🚗' : '🅿️';

            $html .= "<div class='slot-box {$kelasCss}' title='Slot " . chr(64 + $baris) . "{$kolom} - {$statusTeks}'>";
            $html .= "<span class='slot-code'>" . chr(64 + $baris) . "{$kolom}</span>";
            $html .= "<span class='slot-icon'>{$ikon}</span>";
            $html .= "<span class='slot-status'>{$statusTeks}</span>";
            $html .= "</div>";

            $nomorSlot++; // Counter increment
        }
        $html .= "</div></div>";
    }

    $html .= '</div>';
    return $html;
}

// =========================================================================
// [FITUR OPERASIONAL: CHECK-OUT / HAPUS DATA KENDARAAN]
// Memenuhi P2 (Function Prosedural), P3 (Array Unset), P4 (Perbandingan ===),
// dan P7 (Loop FOR untuk pencarian indeks array)
// =========================================================================
/**
 * Menghapus data kendaraan dari session array berdasarkan kode tiket (Check-Out)
 * Mengosongkan kembali slot parkir yang terpakai
 * 
 * @param string $kodeTiket Kode tiket yang ingin dihapus / dikeluarkan
 * @return bool True jika berhasil dihapus, False jika tidak ditemukan
 */
function hapusKendaraan(string $kodeTiket): bool {
    if (!isset($_SESSION['daftar_kendaraan']) || empty($_SESSION['daftar_kendaraan'])) {
        return false;
    }

    $total = count($_SESSION['daftar_kendaraan']);
    $kodeBersih = trim(strtoupper($kodeTiket));

    // [P7 - Perulangan FOR untuk mencari indeks elemen array target]
    for ($i = 0; $i < $total; $i++) {
        // [P4 - Operator Perbandingan ===]
        if (isset($_SESSION['daftar_kendaraan'][$i]['kode_tiket']) && 
            strtoupper(trim($_SESSION['daftar_kendaraan'][$i]['kode_tiket'])) === $kodeBersih) {
            
            // [P3 - Manipulasi Tipe Data Array: unset dan re-index array_values]
            unset($_SESSION['daftar_kendaraan'][$i]);
            $_SESSION['daftar_kendaraan'] = array_values($_SESSION['daftar_kendaraan']);
            return true;
        }
    }

    return false;
}
