# SmartPark - Proyek Integrasi Pemrograman Berbasis Web (Pertemuan 1–7)

Mini aplikasi web PHP berbasis studi kasus **Parkir / Kendaraan** yang mengintegrasikan seluruh kompetensi materi perkuliahan Pertemuan 1 sampai 7.

---

## 📋 Identitas Proyek
- **Mata Kuliah**: Pemrograman Berbasis Web
- **Dosen Pengampu**: Ari Wibowo, S.Kom., M.Kom
- **Studi Kasus**: Studi Kasus 5 — Parkir / Kendaraan
- **Teknologi**: PHP Native 8.x, Apache (XAMPP), HTML5, CSS3 Modern, FontAwesome

---

## 📁 Struktur Folder Proyek
Sesuai dengan ketentuan struktur folder pada panduan tugas:

```text
project_kelompok/
├── index.php             # Halaman utama, dashboard statistik, visualisasi slot & form input
├── proses.php            # Halaman pemrosesan transaksi, cetak tiket, & eksekusi loop WHILE/DO-WHILE
├── laporan.php           # Halaman rekapitulasi data, tabel riwayat (FOR loop), & pencarian
├── functions.php         # Kumpulan fungsi prosedural bisnis & manipulasi string
├── classes/
│   └── Kendaraan.php     # Class OOP entitas Kendaraan (properti, method kalkulasi, status)
├── data/
│   └── sample.php        # Master tarif, konstanta sistem, & data inisial session
├── assets/
│   ├── css/
│   │   └── style.css     # Desain UI modern, responsif, & siap cetak
│   └── images/           # Asset pendukung gambar / logo
├── README.md             # Petunjuk teknis dan ringkasan pemenuhan matriks
└── DOKUMENTASI_TUGAS.md  # Template laporan siap cetak PDF & panduan presentasi tim
```

---

## 🎯 Pembuktian Matriks Kompetensi Wajib (P1–P7)

| Pertemuan | Kompetensi | Bukti Implementasi Konkret | Lokasi File & Baris Kode |
| :--- | :--- | :--- | :--- |
| **P1** | **Paradigma PHP & Sintaks Dasar** | Pemrosesan web dinamis di XAMPP, form handling HTTP POST/GET, pemisahan view dan logic. | `index.php`, `proses.php` |
| **P2** | **Procedural & OOP** | Fungsi prosedural (`hitungBiayaParkir()`, `formatRupiah()`, `hapusKendaraan()`) dan 1 Class OOP (`class Kendaraan`) dengan instansiasi object. | `functions.php:L18, L279` & `classes/Kendaraan.php:L11` |
| **P3** | **Variabel, Scope & Tipe Data** | Menggunakan 5 tipe data (`string`, `int`, `float`, `bool`, `array`), konstanta (`define()` & `const`), serta Type Casting eksplisit `(int)`, `(float)`, `(string)`. | `data/sample.php:L15-L22` & `functions.php:L21-L24` |
| **P4** | **Operator & Manipulasi String** | Operator aritmatika (`+ - * / %`), perbandingan, logika (`&& ||`), ternary (`? :`). Serta minimal 4 teknik string: `trim()`, `strtoupper()`, `strlen()`, `substr()`, `str_replace()`, `htmlspecialchars()`. | `functions.php:L32-L100` & `classes/Kendaraan.php:L105-L135` |
| **P5** | **Perulangan WHILE** | Loop berbasis kondisi (`while ($antreanSisa > 0)`) untuk simulasi pemrosesan antrean kendaraan di gerbang masuk. | `functions.php:L129-L150` |
| **P6** | **Perulangan DO-WHILE** | Loop dengan jaminan minimal 1 kali eksekusi (`do { ... } while (...)`) untuk checklist verifikasi tiket pos keluar. | `functions.php:L166-L195` |
| **P7** | **Perulangan FOR** | Perulangan counter, nested FOR loop untuk visualisasi denah slot parkir (baris x kolom), render data tabel HTML, dan pencarian indeks hapus data. | `functions.php:L207-L280` & `laporan.php:L236-L286` |

---

## 🚀 Cara Menjalankan Aplikasi di XAMPP

1. Pastikan folder proyek berada di direktori `htdocs` XAMPP:
   ```text
   C:\xampp\htdocs\project_kelompok
   ```
2. Buka aplikasi **XAMPP Control Panel**, lalu klik tombol **Start** pada modul **Apache**.
3. Buka web browser (Google Chrome, Microsoft Edge, Mozilla Firefox).
4. Akses URL berikut:
   ```text
   http://localhost/project_kelompok/
   ```
5. Anda dapat langsung:
   - Mencoba memasukkan plat kendaraan baru pada form dashboard.
   - Melihat hasil tiket digital dan simulasi perulangan WHILE / DO-WHILE di `proses.php`.
   - Melihat data rekap, statistik, dan pencarian plat pada menu **Rekap Laporan** (`laporan.php`).

---

## 👥 Rekomendasi Pembagian Tugas Kelompok (4–5 Orang)
- **Koordinator / System Analyst**: Menyusun alur logika, diagram arsitektur, dan checklist matriks P1–P7.
- **PHP Developer A**: Mengimplementasikan `functions.php` (prosedural, manipulasi string, dan loop P5/P6).
- **PHP Developer B**: Mengimplementasikan `classes/Kendaraan.php` (OOP, konstanta, operator, type casting).
- **Tester & Dokumentasi**: Menguji input validasi, membuat screenshot hasil, dan menyusun laporan PDF.
- **Presenter / UI Integrator**: Merakit tampilan antarmuka `index.php`, `laporan.php`, navigasi, dan memimpin demo saat presentasi.
