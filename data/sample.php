<?php
/**
 * =========================================================================
 * DATA MASTER & SAMPLE (data/sample.php)
 * Memenuhi Kompetensi P3 (Konstanta, Tipe Data, Array)
 * =========================================================================
 */

// Memulai session PHP untuk penyimpanan state transaksi sementara
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =========================================================================
// [P3 - KONSTANTA MENGGUNAKAN define() dan const]
// =========================================================================
define('NAMA_SISTEM', 'SmartPark Terpadu');
define('INSTITUSI', 'Praktikum Pemrograman Berbasis Web');
define('KAPASITAS_SLOT_TOTAL', 24); // Kapasitas 24 slot untuk visual grid 4x6
define('PERSENTASE_DISKON_MEMBER', 0.10); // 10% diskon

const VERSI_APLIKASI = '1.0.0';
const MATA_UANG = 'Rp';

// =========================================================================
// [P3 - TIPE DATA ARRAY: Indexed Array & Associative Multidimensional Array]
// =========================================================================
$masterTarif = [
    'MOTOR' => [
        'nama'      => 'Sepeda Motor',
        'tarif_jam' => 2000.0,
        'ikon'      => 'fa-motorcycle'
    ],
    'MOBIL' => [
        'nama'      => 'Mobil Pribadi',
        'tarif_jam' => 5000.0,
        'ikon'      => 'fa-car'
    ],
    'TRUK' => [
        'nama'      => 'Truk / Bus',
        'tarif_jam' => 10000.0,
        'ikon'      => 'fa-truck'
    ]
];

// Data Awal Riwayat Kendaraan (Initial Seed Data)
$initialKendaraan = [
    [
        'kode_tiket'     => 'PK-B12-4821',
        'plat_nomor'     => 'B 1234 ABC',
        'tipe'           => 'MOBIL',
        'durasi_jam'     => 3,
        'is_member'      => true,
        'waktu_masuk'    => date('Y-m-d H:i:s', strtotime('-3 hours')),
        'tarif_per_jam'  => 5000.0,
        'subtotal'       => 13000.0,
        'diskon'         => 1300.0,
        'biaya_admin'    => 1000.0,
        'total_bayar'    => 12700.0,
        'ganjil_genap'   => 'Genap'
    ],
    [
        'kode_tiket'     => 'PK-D88-7312',
        'plat_nomor'     => 'D 8891 ZYX',
        'tipe'           => 'MOTOR',
        'durasi_jam'     => 5,
        'is_member'      => false,
        'waktu_masuk'    => date('Y-m-d H:i:s', strtotime('-5 hours')),
        'tarif_per_jam'  => 2000.0,
        'subtotal'       => 8400.0,
        'diskon'         => 0.0,
        'biaya_admin'    => 1000.0,
        'total_bayar'    => 9400.0,
        'ganjil_genap'   => 'Ganjil'
    ],
    [
        'kode_tiket'     => 'PK-B55-9014',
        'plat_nomor'     => 'B 5502 KLR',
        'tipe'           => 'TRUK',
        'durasi_jam'     => 2,
        'is_member'      => false,
        'waktu_masuk'    => date('Y-m-d H:i:s', strtotime('-2 hours')),
        'tarif_per_jam'  => 10000.0,
        'subtotal'       => 18000.0,
        'diskon'         => 0.0,
        'biaya_admin'    => 1000.0,
        'total_bayar'    => 19000.0,
        'ganjil_genap'   => 'Genap'
    ],
    [
        'kode_tiket'     => 'PK-F41-1129',
        'plat_nomor'     => 'F 4129 XYZ',
        'tipe'           => 'MOBIL',
        'durasi_jam'     => 1,
        'is_member'      => true,
        'waktu_masuk'    => date('Y-m-d H:i:s', strtotime('-1 hours')),
        'tarif_per_jam'  => 5000.0,
        'subtotal'       => 5000.0,
        'diskon'         => 500.0,
        'biaya_admin'    => 1000.0,
        'total_bayar'    => 5500.0,
        'ganjil_genap'   => 'Ganjil'
    ],
    [
        'kode_tiket'     => 'PK-B90-6643',
        'plat_nomor'     => 'B 9000 QWE',
        'tipe'           => 'MOTOR',
        'durasi_jam'     => 4,
        'is_member'      => false,
        'waktu_masuk'    => date('Y-m-d H:i:s', strtotime('-4 hours')),
        'tarif_per_jam'  => 2000.0,
        'subtotal'       => 6800.0,
        'diskon'         => 0.0,
        'biaya_admin'    => 1000.0,
        'total_bayar'    => 7800.0,
        'ganjil_genap'   => 'Genap'
    ]
];

// Inisialisasi data riwayat ke dalam $_SESSION jika belum ada
if (!isset($_SESSION['daftar_kendaraan']) || empty($_SESSION['daftar_kendaraan'])) {
    $_SESSION['daftar_kendaraan'] = $initialKendaraan;
}

/**
 * Helper untuk mengambil list kendaraan aktif
 */
function getDaftarKendaraan(): array {
    return $_SESSION['daftar_kendaraan'] ?? [];
}

/**
 * Helper untuk menambahkan kendaraan baru ke riwayat
 */
function simpanKendaraanBaru(array $dataKendaraan): void {
    if (!isset($_SESSION['daftar_kendaraan'])) {
        $_SESSION['daftar_kendaraan'] = [];
    }
    // Sisipkan di awal array (terbaru paling atas)
    array_unshift($_SESSION['daftar_kendaraan'], $dataKendaraan);
}

/**
 * Helper reset data ke seed awal
 */
function resetDataSample(): void {
    global $initialKendaraan;
    $_SESSION['daftar_kendaraan'] = $initialKendaraan;
}
