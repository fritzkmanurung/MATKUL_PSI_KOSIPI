# KOSIPI (Koperasi Simpan Pinjam) - HMVC & Filament

KOSIPI adalah sistem informasi Koperasi Simpan Pinjam (KOSIPI) modern yang dirancang menggunakan arsitektur HMVC (Hierarchical Model-View-Controller) pada kerangka kerja Laravel dan antarmuka Filament PHP. Sistem ini membagi fitur-fiturnya ke dalam modul independen dan menyediakan dua panel utama (Admin Portal dan Member Portal) dengan kontrol akses berbasis peran (Role-Based Access Control / RBAC).

---

## Fitur Utama Sistem

Sistem KOSIPI dibagi menjadi beberapa modul dan panel fungsional berikut:

### 1. Panel Administrasi (Admin Portal)
Dapat diakses oleh peran pengelola (Super Admin, Ketua, Bendahara, dan Sekretaris) untuk mengelola seluruh aspek operasional koperasi:
* **Manajemen Pengguna**: Pengelolaan hak akses peran dan izin pengguna secara granular menggunakan Filament Shield (Spatie Permission).
* **Data Master Sistem**: Konfigurasi parameter koperasi seperti daftar unit kerja, instansi terafiliasi, status kepegawaian anggota, dan opsi agama.
* **Pengaturan Finansial**: Pengelolaan besaran bunga pinjaman, besaran denda keterlambatan, dan tenggat waktu pembayaran.

### 2. Portal Anggota (Member Portal)
Portal mandiri (self-service) bagi anggota koperasi untuk melacak aktivitas keuangan mereka:
* **Dasbor Keuangan Anggota**: Visualisasi data ringkasan simpanan, tagihan aktif, serta status transaksi terakhir.
* **Buku Transaksi**: Riwayat mutasi simpanan dan pembayaran angsuran pinjaman.
* **Manajemen Profil**: Pengkinian data pribadi anggota secara langsung dari portal.

### 3. Modul Keanggotaan (Membership Module)
* Pengelolaan data anggota koperasi secara mendalam termasuk pencatatan NBA (Nomor Buku Anggota), NIP, NIK, instansi asal, status pernikahan, ahli waris, serta tanggal bergabung.
* Sinkronisasi otomatis antara akun pengguna (User) dengan entitas keanggotaan (Member).

### 4. Modul Simpanan (Deposit Module)
* **Jenis Simpanan**: Mendukung pencatatan Simpanan Pokok, Simpanan Wajib, dan Simpanan Sukarela.
* **Penarikan Sukarela**: Anggota dapat mengajukan penarikan simpanan sukarela dengan validasi batas saldo maksimal penarikan secara waktu nyata.
* **Rekonsiliasi Saldo**: Pencatatan total akumulasi simpanan anggota untuk pelaporan keuangan yang akurat.

### 5. Modul Pinjaman (Loan Module)
* **Pengajuan Pinjaman**: Anggota dapat mengajukan pinjaman dengan nominal tertentu yang akan diverifikasi oleh pihak pengelola.
* **Penjadwalan Tagihan Otomatis**: Pembuatan otomatis jadwal angsuran bulanan (tagihan pinjaman) beserta perhitungan bunga dan kalkulasi denda jika melewati tenggat waktu.

---

## Arsitektur Sistem

Proyek ini mengadopsi pola HMVC menggunakan paket `nwidart/laravel-modules` untuk modularisasi kode. Struktur folder modul terletak di direktori `Modules/` yang memisahkan logika bisnis masing-masing domain:
* **Modules/Keanggotaan**: Model, migrasi basis data, dan kebijakan keanggotaan.
* **Modules/Simpanan**: Logika transaksi simpanan, penarikan, dan pencatatan saldo.
* **Modules/Pinjaman**: Logika pengajuan pinjaman, amortisasi tagihan angsuran, dan pembayaran.
* **Modules/Sistem**: Konfigurasi parameter operasional koperasi.

---

## Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek KOSIPI di lingkungan lokal Anda:

### Prasyarat
Sebelum memulai, pastikan perangkat Anda telah terpasang:
* PHP versi 8.2 atau lebih tinggi
* Composer
* Node.js & NPM
* Server Basis Data (MySQL, PostgreSQL, atau SQLite)

### Langkah 1: Kloning Repositori
Kloning repositori proyek dari GitHub ke perangkat lokal Anda:
```bash
git clone https://github.com/fritzkmanurung/MATKUL_PSI_KOSIPI.git
cd MATKUL_PSI_KOSIPI
```

### Langkah 2: Instal Dependensi
Instal pustaka PHP melalui Composer dan pustaka Javascript melalui NPM:
```bash
composer install
npm install
```

### Langkah 3: Konfigurasi Lingkungan (.env)
Salin berkas contoh konfigurasi `.env.example` menjadi `.env` lalu buat kunci enkripsi aplikasi:
```bash
copy .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi basis data Anda di dalam berkas `.env` yang baru dibuat (misalnya konfigurasi MySQL atau SQLite). Jika menggunakan SQLite:
```env
DB_CONNECTION=sqlite
# Kosongkan konfigurasi DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, dan DB_PASSWORD untuk SQLite default
```
*Catatan: Jika menggunakan SQLite, pastikan berkas basis data kosong `database/database.sqlite` telah dibuat terlebih dahulu.*

### Langkah 4: Migrasi dan Seed Basis Data
Jalankan migrasi basis data untuk membuat tabel-tabel sistem, diikuti dengan menjalankan seed untuk mengisi data master awal dan akun demo:
```bash
php artisan migrate --seed
```

### Langkah 5: Jalankan Aplikasi
Jalankan server lokal Laravel dan compiler aset Vite:

Buka terminal pertama untuk menjalankan Laravel Development Server:
```bash
php artisan serve
```

Buka terminal kedua untuk menjalankan Vite Development Server:
```bash
npm run dev
```

Aplikasi kini dapat diakses melalui browser Anda di URL:
* **Portal Utama**: http://127.0.0.1:8000
* **Admin Portal**: http://127.0.0.1:8000/admin
* **Member Portal**: http://127.0.0.1:8000/member

---

## Akun Demo untuk Pengujian

Gunakan akun demo berikut yang telah dibuat secara otomatis oleh seeder untuk menguji berbagai peran di dalam sistem (kata sandi untuk semua akun demo adalah `password`):

| Peran (Role) | Alamat Email | Kata Sandi | Deskripsi Akses |
| --- | --- | --- | --- |
| Super Admin | admin@kosipi.com | password | Akses penuh seluruh sistem dan manajemen hak akses |
| Ketua Koperasi | admin2@kosipi.com | password | Akses kelola data master dan keuangan tanpa manajemen otorisasi sistem |
| Bendahara | bendahara@kosipi.com | password | Kelola transaksi simpanan, penarikan, dan pinjaman |
| Sekretaris | pengawas@kosipi.com | password | Read-only data keuangan dan kelola penuh data keanggotaan |
| Anggota (Member) | anggota@kosipi.com | password | Akses ke portal self-service member untuk memantau tabungan dan pinjaman |

---

## Lisensi
Sistem ini dirilis di bawah lisensi [MIT](LICENSE).
