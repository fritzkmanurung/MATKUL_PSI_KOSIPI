# Rencana Implementasi KOSIPI

Rencana ini merinci langkah-langkah untuk mengimplementasikan 4 permintaan fitur utama.

## ⚠️ User Review Required

Silakan periksa dan setujui rencana ini, terutama pada bagian **Pertanyaan Terbuka** di bawah terkait sistem Tagihan Simpanan Wajib.

---

## Proposed Changes

### 1. Integrasi Simpanan Pokok saat Pembuatan Akun (Admin)
- **Modifikasi Form:** Menambahkan input `simpanan_pokok` berupa angka (numeric) di `UserForm.php` panel Admin yang tidak dikaitkan langsung ke tabel `users` (unmapped).
- **Hook Proses:** Pada file `CreateUser.php`, memanfaatkan form hooks (`afterCreate`) untuk membaca nilai `simpanan_pokok` tersebut.
- **Auto-Create:** Sistem akan otomatis meng-generate _record_ di tabel `simpanans` dengan `jenis_simpanan = 'Pokok'` dan `status = 'Diterima'` untuk user yang baru saja dibuat tersebut.

---

### 2. Validasi & Tampilan Maksimal Penarikan (Sukarela)
- **Modifikasi Tampilan Form:** Di `PenarikanAnggotaForm.php`, kita akan tambahkan komponen teks (Placeholder) yang menampilkan secara langsung "Sisa Saldo Sukarela: Rp X.XXX.XXX".
- **Validasi Kuota:** Mengaplikasikan aturan `maxValue($sisaSukarela)` pada input `nominal_penarikan`. Jika member mencoba menarik lebih dari itu, form akan menolak (error validasi muncul otomatis).

---

### 3. Ekstensi Profil Member & Auto-fill Pinjaman
- **Migrasi Database [NEW]:** Membuat migrasi baru untuk menambahkan kolom data diri ke tabel `users`:
  - `pekerjaan`
  - `status_pegawai`
  - `status_perkawinan`
  - `masa_kontrak`
  - `nama_suami_istri`
- **Menu Profil Anggota [MODIFY]:** 
  - Mengaktifkan fitur `->profile()` di `MemberPanelProvider`.
  - Mengubah form profil standar untuk menyertakan 5 field data diri di atas sehingga Member dapat melengkapinya sendiri.
- **Sinkronisasi Dasbor Admin [MODIFY]:** Memasukkan field yang sama ke `UserForm.php` agar admin juga bisa mengeditnya.
- **Auto-Fill Pinjaman [MODIFY]:** Di `CreatePinjamanAnggota.php`, saat Anggota menekan tombol submit pengajuan pinjaman, nilai profil kreditur tidak akan diisi kosongan (`'-'`) lagi, melainkan otomatis **ditarik / di-*copy*** dari profil `auth()->user()`.

---

### 4. Ekstensi Tagihan (Simpanan Wajib & Angsuran)
- **Pembuatan Model/Tabel Baru [NEW]:** Karena secara struktural Tagihan Pinjaman dan Tagihan Simpanan Wajib itu berbeda, saya akan membuat model & tabel baru: `TagihanSimpananWajib`.
- **Modifikasi UI Member [MODIFY]:** Menu "Tagihan Angsuran Pribadi" akan kita pisah menjadi 2 menu yang lebih jelas:
  1. **Tagihan Simpanan Wajib (Bulanan)**
  2. **Tagihan Angsuran Pinjaman**
  *(atau bisa digabungkan di satu halaman (Tab) bergantung kesepakatan).*

---

## ❓ Open Questions

Terkait **Poin 4 (Tagihan Simpanan Wajib)**, mohon arahan desain bisnisnya:
1. **Bagaimana Tagihan Simpanan Wajib terbentuk?** Apakah Koperasi memiliki tanggal tertentu (misal: setiap tanggal 1 setiap bulan) di mana sistem akan *otomatis* menerbitkan 1 Tagihan Simpanan Wajib untuk semua anggota aktif secara bulk?
2. **Penggabungan UI:** Apakah Anda setuju jika menu tagihan dipecah menjadi dua menu di sidebar member (satu untuk Wajib, satu untuk Pinjaman) agar data tidak bercampur karena struktur kolomnya berbeda?

---

## Verification Plan

### Manual Verification
1. Super Admin membuat user baru dengan menginput sejumlah Rp 50.000 di kolom "Simpanan Pokok Awal". Cek di list Simpanan apakah tercatat "Diterima".
2. Anggota membuka menu "Pencairan". Terlihat sisa saldo Sukarela. Jika menarik Rp 1.000.000 padahal saldo Rp 500.000, maka *submit decline*.
3. Anggota login, masuk ke fitur "Profile", melengkapi pekerjaan & status pegawai. Lalu submit Pinjaman, cek di sisi Admin apakah data diri tersebut terangkut dengan benar.
4. Cek menu tagihan yang telah disesuaikan strukturnya.
