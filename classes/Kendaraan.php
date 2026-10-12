<?php
/**
 * =========================================================================
 * KELAS OOP: KENDARAAN (classes/Kendaraan.php)
 * Memenuhi Kompetensi P2 (Procedural & OOP) serta P3, P4
 * =========================================================================
 * Deskripsi:
 * Class Kendaraan merepresentasikan entitas kendaraan parkir dengan
 * enkapsulasi properti (private/protected), konstruktor, dan method bisnis.
 */

class Kendaraan {
    // =====================================================================
    // [P3 - TIPE DATA & PROPERTI CLASS]
    // =====================================================================
    private string $platNomor;      // Tipe Data String
    private string $tipe;           // Tipe Data String (Motor, Mobil, Truk/Bus)
    private int $durasiJam;         // Tipe Data Integer (Lama parkir dalam jam)
    private bool $isMember;         // Tipe Data Boolean (Status member/langganan)
    private string $waktuMasuk;     // Tipe Data String format waktu
    private string $kodeTiket;      // Tipe Data String kode unik tiket
    private float $tarifPerJam;     // Tipe Data Float (Tarif per jam)
    private float $biayaAdmin;      // Tipe Data Float (Biaya administrasi pos)

    /**
     * Konstruktor untuk inisialisasi Object Kendaraan
     */
    public function __construct(
        string $platNomor,
        string $tipe,
        int $durasiJam,
        bool $isMember = false,
        string $waktuMasuk = ''
    ) {
        $this->platNomor   = $platNomor;
        $this->tipe        = $tipe;
        $this->durasiJam   = $durasiJam;
        $this->isMember    = $isMember;
        $this->waktuMasuk  = empty($waktuMasuk) ? date('Y-m-d H:i:s') : $waktuMasuk;
        $this->biayaAdmin  = 1000.0; // [P3] Float default

        // Menentukan tarif dasar berdasarkan jenis kendaraan
        $this->setTarifDasar();

        // Generate kode tiket otomatis
        $this->generateKodeTiket();
    }

    /**
     * Method Private untuk menetapkan tarif dasar per jam
     */
    private function setTarifDasar(): void {
        switch (strtoupper($this->tipe)) {
            case 'MOTOR':
                $this->tarifPerJam = 2000.0;
                break;
            case 'MOBIL':
                $this->tarifPerJam = 5000.0;
                break;
            case 'TRUK':
            case 'BUS':
                $this->tarifPerJam = 10000.0;
                break;
            default:
                $this->tarifPerJam = 3000.0;
                break;
        }
    }

    /**
     * Method untuk membuat kode tiket unik berbasis timestamp dan substring plat
     * [P4 - Manipulasi String substr, strtoupper, str_replace]
     */
    private function generateKodeTiket(): void {
        $bersih = str_replace(' ', '', $this->platNomor);
        $prefix = strtoupper(substr($bersih, 0, 3));
        $this->kodeTiket = 'PK-' . $prefix . '-' . rand(1000, 9999);
    }

    // =====================================================================
    // GETTER METHODS
    // =====================================================================
    public function getPlatNomor(): string {
        return $this->platNomor;
    }

    public function getTipe(): string {
        return $this->tipe;
    }

    public function getDurasiJam(): int {
        return $this->durasiJam;
    }

    public function isMember(): bool {
        return $this->isMember;
    }

    public function getWaktuMasuk(): string {
        return $this->waktuMasuk;
    }

    public function getKodeTiket(): string {
        return $this->kodeTiket;
    }

    public function getTarifPerJam(): float {
        return $this->tarifPerJam;
    }

    public function getBiayaAdmin(): float {
        return $this->biayaAdmin;
    }

    // =====================================================================
    // [P4 - OPERATOR ARITMATIKA, LOGIKA, PERBANDINGAN, TERNARY]
    // =====================================================================

    /**
     * Menghitung subtotal sebelum diskon
     * Menggunakan operator perkalian (*) dan pertambahan (+)
     */
    public function hitungSubtotal(): float {
        // Jam pertama dikenakan tarif flat, jam berikutnya tarif per jam
        if ($this->durasiJam <= 1) {
            return (float)$this->tarifPerJam; // [P3] Type Casting Float
        }
        // [P4] Operator Aritmatika: + dan *
        return (float)($this->tarifPerJam + (($this->durasiJam - 1) * ($this->tarifPerJam * 0.8)));
    }

    /**
     * Menghitung potongan diskon (10% jika member VIP)
     * Menggunakan operator ternary (?) dan logika
     */
    public function hitungDiskon(): float {
        $subtotal = $this->hitungSubtotal();
        // [P4] Operator Ternary & Perbandingan
        return ($this->isMember === true) ? ($subtotal * 0.10) : 0.0;
    }

    /**
     * Menghitung total akhir pembayaran parkir
     * Operator: Subtotal - Diskon + Biaya Admin
     */
    public function hitungTotalBayar(): float {
        $subtotal = $this->hitungSubtotal();
        $diskon   = $this->hitungDiskon();
        // [P4] Operator Aritmatika -, +
        $total = ($subtotal - $diskon) + $this->biayaAdmin;
        return round($total, 2);
    }

    /**
     * Memeriksa aturan ganjil-genap nomor plat
     * [P4 - Operator Modulus % dan Logika]
     */
    public function cekGanjilGenap(): string {
        // Ambil hanya angka dari nomor plat
        preg_match('/\d+/', $this->platNomor, $matches);
        if (!empty($matches)) {
            $nomorAngka = (int)$matches[0]; // [P3] Type casting int
            // [P4] Operator Modulus % dan perbandingan ==
            return ($nomorAngka % 2 == 0) ? 'Genap' : 'Ganjil';
        }
        return 'Tidak Terdeteksi';
    }

    /**
     * Memberikan status badge HTML untuk member
     * [P4 - Operator Ternary]
     */
    public function getStatusMemberBadge(): string {
        return $this->isMember 
            ? '<span class="badge badge-success"><i class="fa fa-star"></i> Member VIP</span>'
            : '<span class="badge badge-secondary">Reguler</span>';
    }

    /**
     * Menghasilkan ringkasan lengkap dalam bentuk array asosiatif
     * [P3 - Tipe Data Array]
     */
    public function toArray(): array {
        return [
            'kode_tiket'     => $this->kodeTiket,
            'plat_nomor'     => $this->platNomor,
            'tipe'           => $this->tipe,
            'durasi_jam'     => $this->durasiJam,
            'is_member'      => $this->isMember,
            'waktu_masuk'    => $this->waktuMasuk,
            'tarif_per_jam'  => $this->tarifPerJam,
            'subtotal'       => $this->hitungSubtotal(),
            'diskon'         => $this->hitungDiskon(),
            'biaya_admin'    => $this->biayaAdmin,
            'total_bayar'    => $this->hitungTotalBayar(),
            'ganjil_genap'   => $this->cekGanjilGenap()
        ];
    }
}
