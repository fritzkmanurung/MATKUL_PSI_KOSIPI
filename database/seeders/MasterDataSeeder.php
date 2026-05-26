<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sistem\Models\Agama;
use Modules\Sistem\Models\UnitKerja;
use Modules\Sistem\Models\Instansi;
use Modules\Sistem\Models\Status;
use Modules\Sistem\Models\Bunga;
use Modules\Sistem\Models\DendaKeterlambatan;
use Modules\Sistem\Models\TenggatWaktu;
use Modules\Simpanan\Models\BesaranSimpanan;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Agama (6 Agama Resmi Indonesia)
        $agamas = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        foreach ($agamas as $agama) {
            Agama::firstOrCreate(['nama' => $agama]);
        }

        // 2. Unit Kerja
        $unitKerjas = ['Petugas Perpustakaan', 'Guru', 'Dosen', 'Petugas Kebersihan'];
        foreach ($unitKerjas as $unit) {
            UnitKerja::firstOrCreate(['nama' => $unit]);
        }

        // 3. Instansi
        $instansis = ['Institut Teknologi Del', 'SMA Unggul Del'];
        foreach ($instansis as $instansi) {
            Instansi::firstOrCreate(['nama' => $instansi]);
        }

        // 4. Status Kepegawaian
        $statuses = ['Pekerja Tetap', 'Kontrak'];
        foreach ($statuses as $status) {
            Status::firstOrCreate(['nama' => $status]);
        }

        // 5. Bunga Pinjaman (1 aktif default)
        Bunga::firstOrCreate(
            ['nama' => 'Bunga Reguler'],
            ['nilai_persen' => 1.50, 'keterangan' => 'Bunga standar koperasi', 'is_aktif' => true]
        );
        Bunga::firstOrCreate(
            ['nama' => 'Bunga Khusus'],
            ['nilai_persen' => 0.75, 'keterangan' => 'Bunga khusus untuk pegawai tetap', 'is_aktif' => false]
        );

        // 6. Besaran Simpanan
        BesaranSimpanan::firstOrCreate(
            ['jenis_simpanan' => 'Pokok'],
            ['nominal' => 100000, 'is_aktif' => true]
        );
        BesaranSimpanan::firstOrCreate(
            ['jenis_simpanan' => 'Wajib'],
            ['nominal' => 50000, 'is_aktif' => true]
        );

        // 7. Denda Keterlambatan
        DendaKeterlambatan::firstOrCreate(
            ['jenis_denda' => 'Simpanan Wajib'],
            ['nominal_denda' => 5000, 'is_aktif' => true]
        );
        DendaKeterlambatan::firstOrCreate(
            ['jenis_denda' => 'Pinjaman'],
            ['nominal_denda' => 10000, 'is_aktif' => true]
        );

        // 8. Tenggat Waktu
        TenggatWaktu::firstOrCreate(
            ['jenis_tagihan' => 'Simpanan'],
            ['tanggal_mulai' => 1, 'tanggal_akhir' => 10, 'is_aktif' => true]
        );
        TenggatWaktu::firstOrCreate(
            ['jenis_tagihan' => 'Pinjaman'],
            ['tanggal_mulai' => 1, 'tanggal_akhir' => 7, 'is_aktif' => true]
        );
    }
}
