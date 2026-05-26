<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Modules\Keanggotaan\Models\Member;
use Illuminate\Support\Facades\Hash;

class DemoAccountSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // 1. BUAT SEMUA PERMISSION
        // =====================================================
        $resources = [
            'User', 'Simpanan', 'Penarikan', 'Pinjaman',
            'TagihanPinjaman', 'TotalSimpanan', 'Bunga',
            'Agama', 'UnitKerja', 'Instansi', 'Status', 'TagihanWajib'
        ];

        $actions = ['ViewAny', 'View', 'Create', 'Update', 'Delete', 'DeleteAny'];

        $allPermissions = [];
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permName = "{$action}:{$resource}";
                Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
                $allPermissions[] = $permName;
            }
        }

        // Shield permissions (sudah ada, tinggal ambil)
        $shieldPermissions = Permission::where('name', 'like', '%:Role')->pluck('name')->toArray();

        // =====================================================
        // 2. SETUP ROLES DENGAN PERMISSION
        // =====================================================

        // --- SUPER ADMIN: Akses SEMUA ---
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(array_merge($allPermissions, $shieldPermissions));

        // --- KETUA: Semua kecuali Shield ---
        $ketua = Role::firstOrCreate(['name' => 'ketua', 'guard_name' => 'web']);
        $ketua->syncPermissions($allPermissions);

        // --- BENDAHARA: Semua keuangan, TIDAK bisa kelola User ---
        $bendahara = Role::firstOrCreate(['name' => 'bendahara', 'guard_name' => 'web']);
        $bendaharaPermissions = [];
        $bendaharaResources = [
            'Simpanan', 'Penarikan', 'Pinjaman', 'TagihanPinjaman',
            'TotalSimpanan', 'Bunga', 'Agama', 'UnitKerja', 'Instansi', 'Status',
        ];
        foreach ($bendaharaResources as $resource) {
            foreach ($actions as $action) {
                $bendaharaPermissions[] = "{$action}:{$resource}";
            }
        }
        $bendahara->syncPermissions($bendaharaPermissions);

        // --- SEKRETARIS: Read-only semua + Keanggotaan Full ---
        $sekretaris = Role::firstOrCreate(['name' => 'sekretaris', 'guard_name' => 'web']);
        $sekretarisPermissions = [];
        foreach ($resources as $resource) {
            $sekretarisPermissions[] = "ViewAny:{$resource}";
            $sekretarisPermissions[] = "View:{$resource}";
        }
        // Tambahkan permission edit untuk Keanggotaan/User jika perlu
        $sekretaris->syncPermissions($sekretarisPermissions);

        // --- ANGGOTA: Tidak punya permission admin panel ---
        $anggota = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);
        // Anggota mengakses portal /member, bukan /admin
        $anggota->syncPermissions([
            'ViewAny:Simpanan', 'View:Simpanan', 'Create:Simpanan', 'Update:Simpanan',
            'ViewAny:TagihanWajib', 'View:TagihanWajib', 'Create:TagihanWajib', 'Update:TagihanWajib',
            'ViewAny:Pinjaman', 'View:Pinjaman', 'Create:Pinjaman', 'Update:Pinjaman',
            'ViewAny:TagihanPinjaman', 'View:TagihanPinjaman', 'Create:TagihanPinjaman', 'Update:TagihanPinjaman',
            'ViewAny:Penarikan', 'View:Penarikan', 'Create:Penarikan', 'Update:Penarikan',
        ]);

        // =====================================================
        // 3. BUAT AKUN DEMO (5 User) — DATA LENGKAP
        // =====================================================

        // Ambil ID master data untuk FK
        $agamaIslam    = \Modules\Sistem\Models\Agama::where('nama', 'Islam')->first()?->id;
        $agamaKristen  = \Modules\Sistem\Models\Agama::where('nama', 'Kristen Protestan')->first()?->id;
        $agamaKatolik  = \Modules\Sistem\Models\Agama::where('nama', 'Katolik')->first()?->id;
        $agamaHindu    = \Modules\Sistem\Models\Agama::where('nama', 'Hindu')->first()?->id;
        $agamaBuddha   = \Modules\Sistem\Models\Agama::where('nama', 'Buddha')->first()?->id;

        $unitGuru      = \Modules\Sistem\Models\UnitKerja::where('nama', 'Guru')->first()?->id;
        $unitDosen     = \Modules\Sistem\Models\UnitKerja::where('nama', 'Dosen')->first()?->id;
        $unitPerpus    = \Modules\Sistem\Models\UnitKerja::where('nama', 'Petugas Perpustakaan')->first()?->id;
        $unitKebersih  = \Modules\Sistem\Models\UnitKerja::where('nama', 'Petugas Kebersihan')->first()?->id;

        $instansiDel   = \Modules\Sistem\Models\Instansi::where('nama', 'Institut Teknologi Del')->first()?->id;
        $instansiSma   = \Modules\Sistem\Models\Instansi::where('nama', 'SMA Unggul Del')->first()?->id;

        $statusTetap   = \Modules\Sistem\Models\Status::where('nama', 'Pekerja Tetap')->first()?->id;
        $statusKontrak = \Modules\Sistem\Models\Status::where('nama', 'Kontrak')->first()?->id;

        $users = [
            [
                'email' => 'admin@kosipi.com',
                'name'  => 'Dr. Maruli Tua Situmorang',
                'role'  => 'superadmin',
                'member' => [
                    'nba'               => 'NBA-001',
                    'nip'                => '198501152010011001',
                    'nik'                => '1201011501850001',
                    'jenis_kelamin'      => 'L',
                    'tempat_lahir'       => 'Laguboti',
                    'tanggal_lahir'      => '1985-01-15',
                    'alamat'             => 'Jl. Sisingamangaraja No. 12, Laguboti, Toba, Sumatera Utara',
                    'no_hp'              => '081234567890',
                    'status_perkawinan'  => 'Kawin',
                    'nama_suami_istri'   => 'Risma Nainggolan',
                    'agama_id'           => $agamaKristen,
                    'unit_kerja_id'      => $unitDosen,
                    'instansi_id'        => $instansiDel,
                    'status_id'          => $statusTetap,
                    'tanggal_bergabung'  => '2020-01-01',
                ]
            ],
            [
                'email' => 'admin2@kosipi.com',
                'name'  => 'Siti Rahmawati Harahap',
                'role'  => 'ketua',
                'member' => [
                    'nba'               => 'NBA-002',
                    'nip'                => '199003222015042002',
                    'nik'                => '1201036203900002',
                    'jenis_kelamin'      => 'P',
                    'tempat_lahir'       => 'Balige',
                    'tanggal_lahir'      => '1990-03-22',
                    'alamat'             => 'Jl. Pematang Siantar No. 45, Balige, Toba, Sumatera Utara',
                    'no_hp'              => '082145678901',
                    'status_perkawinan'  => 'Kawin',
                    'nama_suami_istri'   => 'Parlindungan Siahaan',
                    'agama_id'           => $agamaIslam,
                    'unit_kerja_id'      => $unitGuru,
                    'instansi_id'        => $instansiSma,
                    'status_id'          => $statusTetap,
                    'tanggal_bergabung'  => '2021-02-15',
                ]
            ],
            [
                'email' => 'bendahara@kosipi.com',
                'name'  => 'Theresia Manullang',
                'role'  => 'bendahara',
                'member' => [
                    'nba'               => 'NBA-003',
                    'nip'                => '198807102012042003',
                    'nik'                => '1201035007880003',
                    'jenis_kelamin'      => 'P',
                    'tempat_lahir'       => 'Porsea',
                    'tanggal_lahir'      => '1988-07-10',
                    'alamat'             => 'Jl. Gereja HKBP No. 8, Porsea, Toba, Sumatera Utara',
                    'no_hp'              => '085367890123',
                    'status_perkawinan'  => 'Belum Kawin',
                    'nama_suami_istri'   => null,
                    'agama_id'           => $agamaKatolik,
                    'unit_kerja_id'      => $unitPerpus,
                    'instansi_id'        => $instansiDel,
                    'status_id'          => $statusTetap,
                    'tanggal_bergabung'  => '2022-03-10',
                ]
            ],
            [
                'email' => 'pengawas@kosipi.com',
                'name'  => 'I Wayan Dharma Putra',
                'role'  => 'sekretaris',
                'member' => [
                    'nba'               => 'NBA-004',
                    'nip'                => '197512011999031004',
                    'nik'                => '1201010112750004',
                    'jenis_kelamin'      => 'L',
                    'tempat_lahir'       => 'Singaraja',
                    'tanggal_lahir'      => '1975-12-01',
                    'alamat'             => 'Jl. Tarutung No. 33, Laguboti, Toba, Sumatera Utara',
                    'no_hp'              => '081298765432',
                    'status_perkawinan'  => 'Kawin',
                    'nama_suami_istri'   => 'Ni Made Suryani',
                    'agama_id'           => $agamaHindu,
                    'unit_kerja_id'      => $unitDosen,
                    'instansi_id'        => $instansiDel,
                    'status_id'          => $statusTetap,
                    'tanggal_bergabung'  => '2019-12-01',
                ]
            ],
            [
                'email' => 'anggota@kosipi.com',
                'name'  => 'Budi Santoso Panjaitan',
                'role'  => 'anggota',
                'member' => [
                    'nba'               => 'NBA-005',
                    'nip'                => '199506182020011005',
                    'nik'                => '1201011806950005',
                    'jenis_kelamin'      => 'L',
                    'tempat_lahir'       => 'Medan',
                    'tanggal_lahir'      => '1995-06-18',
                    'alamat'             => 'Jl. Lumban Silintong No. 7, Balige, Toba, Sumatera Utara',
                    'no_hp'              => '089512345678',
                    'status_perkawinan'  => 'Kawin',
                    'nama_suami_istri'   => 'Dewi Sartika Simbolon',
                    'agama_id'           => $agamaBuddha,
                    'unit_kerja_id'      => $unitKebersih,
                    'instansi_id'        => $instansiSma,
                    'status_id'          => $statusKontrak,
                    'tanggal_bergabung'  => '2023-01-20',
                    'nama_ahli_waris'    => 'Dewi Sartika Simbolon',
                    'hubungan_ahli_waris' => 'Istri',
                ]
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $user->syncRoles($userData['role']);

            // Buat data member
            Member::updateOrCreate(
                ['user_id' => $user->id],
                $userData['member']
            );
        }
    }
}
