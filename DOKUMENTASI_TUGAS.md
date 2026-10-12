# LAPORAN & DOKUMENTASI PROYEK INTEGRASI PBW (PERTEMUAN 1–7)

---

## 📌 1. INFORMASI PROYEK & KELOMPOK
- **Judul Proyek**: SmartPark - Sistem Manajemen & Kalkulasi Tarif Parkir Terintegrasi
- **Mata Kuliah**: Pemrograman Berbasis Web
- **Dosen Pengampu**: Ari Wibowo, S.Kom., M.Kom
- **Studi Kasus Dipilih**: **Studi Kasus 5 — Parkir / Kendaraan**
- **Ruang Lingkup Integrasi**: Pertemuan 1 s/d Pertemuan 7 (Paradigma PHP, XAMPP, Variabel, Operator, String, WHILE, DO-WHILE, FOR, Procedural & OOP)

---

## 👥 2. PEMBAGIAN PERAN & TUGAS TIM (4–5 MAHASISWA)

| No | Peran Kelompok | Nama Mahasiswa / NIM (Isi Sesuai Tim) | Tanggung Jawab & Kontribusi Nyata |
| :--- | :--- | :--- | :--- |
| 1 | **Koordinator / System Analyst** | [Nama Anggota 1] | Merancang arsitektur sistem, membagi tugas tim, memastikan seluruh checklist kompetensi P1–P7 terpenuhi 100%. |
| 2 | **PHP Developer A** | [Nama Anggota 2] | Menyusun file `functions.php`, membuat fungsi prosedural `hitungBiayaParkir()`, `normalisasiPlatNomor()`, serta implementasi loop WHILE & DO-WHILE. |
| 3 | **PHP Developer B** | [Nama Anggota 3] | Menyusun file `classes/Kendaraan.php`, membangun struktur OOP (enkapsulasi properti, method kalkulasi diskon, status ganjil-genap, type casting). |
| 4 | **Tester & Dokumentasi** | [Nama Anggota 4] | Menyusun skenario pengujian input (valid/invalid), mendokumentasikan screenshot hasil output, menyusun file README dan laporan akhir. |
| 5 | **Presenter / UI Integrator** | [Nama Anggota 5] | Mengintegrasikan komponen HTML/CSS pada `index.php`, `proses.php`, `laporan.php`, memimpin demonstrasi aplikasi saat presentasi kelas. |

---

## ⚙️ 3. PENJELASAN FITUR DAN ALUR SISTEM

### A. Alur Kerja Aplikasi (Workflow):
1. **Pencatatan Masuk (Check-In)**:
   - Petugas memasukkan Plat Nomor Kendaraan, Jenis Kendaraan (Motor / Mobil / Truk), estimasi durasi, dan status keanggotaan (Member VIP).
   - Sistem melakukan sanitasi dan normalisasi string (`trim()`, `strtoupper()`, validasi panjang karakter).
2. **Kalkulasi Biaya & Instansiasi Objek**:
   - Sistem membuat objek `Kendaraan` baru melalui paradigma OOP.
   - Perhitungan biaya menerapkan aturan tarif progresif (jam ke-1 flat, jam berikutnya diskon progresif, diskon member VIP 10%, dan biaya administrasi).
   - Penentuan aturan ganjil-genap menggunakan operator aritmatika modulus (`%`).
3. **Simulasi Gate & Sensor (Struktur Perulangan)**:
   - **Loop WHILE**: Mensimulasikan pemrosesan antrean kendaraan di gerbang masuk satu demi satu hingga antrean habis.
   - **Loop DO-WHILE**: Mensimulasikan checklist verifikasi tiket dan kamera gerbang keluar yang menjamin pemeriksaan dijalankan minimal 1 kali.
4. **Rekapitulasi & Pelaporan (Check-Out & Laporan)**:
   - Halaman `laporan.php` menampilkan seluruh log riwayat kendaraan dalam bentuk tabel HTML menggunakan perulangan **FOR**.
   - Menyediakan fitur pencarian cepat berdasarkan nomor plat atau kode tiket serta statistik akumulasi pendapatan.

---

## 📊 4. MATRIKS PEMENUHAN KOMPETENSI WAJIB (P1–P7)

| Pertemuan | Standar Kompetensi | Bukti Implementasi Konkret | File & Baris Kode Kunci |
| :--- | :--- | :--- | :--- |
| **P1** | **Paradigma PHP & Sintaks Dasar** | Web dinamis berjalan di server lokal Apache (XAMPP), form request `POST` dan `GET`, serta pemisahan logika bisnis dari view. | `index.php:L10` & `proses.php:L11` |
| **P2** | **Procedural & OOP** | Fungsi prosedural (`hitungBiayaParkir()`, `formatRupiah()`, `normalisasiPlatNomor()`, `hapusKendaraan()`) dan 1 Class OOP (`class Kendaraan`) lengkap dengan constructor dan method. | `functions.php:L18-L45, L279`<br>`classes/Kendaraan.php:L11-L60` |
| **P3** | **Variabel, Scope & Tipe Data** | Menggunakan 5 tipe data (`string`, `int`, `float`, `bool`, `array`), konstanta (`define()`, `const`), serta konversi type casting eksplisit. | `data/sample.php:L15-L25`<br>`functions.php:L21-L24` |
| **P4** | **Operator & String** | Operator aritmatika (`+ - * / %`), perbandingan (`== === > <`), logika (`&& \|\|`), ternary (`? :`), serta 6 fungsi string: `trim()`, `strtoupper()`, `strlen()`, `substr()`, `str_replace()`, `htmlspecialchars()`. | `classes/Kendaraan.php:L105-L135`<br>`functions.php:L55-L100` |
| **P5** | **Perulangan WHILE** | Loop berbasis kondisi `while ($antreanSisa > 0)` untuk simulasi pengosongan antrean gerbang parkir. | `functions.php:L129-L150` |
| **P6** | **Perulangan DO-WHILE** | Loop dengan evaluasi kondisi di akhir `do { ... } while (...)` untuk menjamin checklist verifikasi sensor gerbang berjalan minimal 1 kali. | `functions.php:L166-L195` |
| **P7** | **Perulangan FOR** | Perulangan counter, nested FOR loop untuk render 24 kotak visual slot parkir, iterasi tabel data laporan, serta loop pencarian indeks check-out data. | `functions.php:L207-L280`<br>`laporan.php:L236-L286` |

---

## 🎤 5. PANDUAN SKENARIO PRESENTASI (15–20 MENIT)

Sesuai ketentuan slide 13, seluruh anggota kelompok wajib berbicara dan mendemonstrasikan kode kunci:

1. **Menit 01–03: Pembukaan & Latar Belakang (Koordinator)**
   - Menyapa dosen pengampu, memperkenalkan anggota kelompok dan pembagian peran.
   - Menjelaskan studi kasus Parkir Kendaraan dan arsitektur folder proyek.
2. **Menit 04–08: Demonstrasi Fitur Aplikasi di Browser (Presenter / UI Integrator)**
   - Buka browser di `http://localhost/project_kelompok/`.
   - Perlihatkan form input kendaraan, isi plat nomor baru, pilih jenis dan durasi, klik proses.
   - Tunjukkan hasil Karcis Parkir digital dan jelaskan visualisasi denah slot parkir.
   - Tunjukkan halaman Rekap Laporan dan filter pencarian data.
3. **Menit 09–13: Penjelasan Kode Prosedural & OOP (PHP Dev A & PHP Dev B)**
   - Tunjukkan kode `classes/Kendaraan.php`: Jelaskan constructor, enkapsulasi properti, dan method kalkulasi.
   - Tunjukkan kode `functions.php`: Jelaskan fungsi hitung biaya, type casting, dan 4+ teknik manipulasi string.
4. **Menit 14–17: Penjelasan Perulangan WHILE, DO-WHILE, FOR (PHP Dev A & B)**
   - Tunjukkan blok loop **WHILE** pada fungsi `simulasiAntreanWhile()`.
   - Tunjukkan blok loop **DO-WHILE** pada fungsi `simulasiPemeriksaanDoWhile()`.
   - Tunjukkan blok loop **FOR** pada pembuatan tabel laporan dan denah slot visual.
5. **Menit 18–20: Skenario Pengujian, Kendala, Solusi & Penutup (Tester & Koordinator)**
   - Menjelaskan hasil pengujian validasi (misal jika durasi kosong atau plat terlalu pendek).
   - Membuka sesi tanya jawab dengan dosen.

---

## 🛠️ 6. KENDALA TEKNIS DAN SOLUSI

1. **Kendala**: Menjaga persistensi data transaksi baru tanpa basis data MySQL (agar ringan dan sesuai lingkup materi P1–P7).  
   **Solusi**: Menggunakan `$_SESSION` PHP yang diinisialisasi dengan data contoh awal di `data/sample.php`, sehingga data yang diinput lewat form langsung tersimpan dan dapat direkap di `laporan.php`.
2. **Kendala**: Memastikan perulangan DO-WHILE memiliki makna fungsional nyata dan bukan sekadar contoh buatan.  
   **Solusi**: Diterapkan pada simulasi checklist pos keluar di mana scan tiket fisik wajib dieksekusi minimal satu kali sebelum gerbang dibuka.
3. **Kendala**: Format plat nomor kendaraan yang bervariasi dari input user.  
   **Solusi**: Menerapkan fungsi normalisasi terpadu dengan `trim()`, `strtoupper()`, dan validasi panjang `strlen()`.
