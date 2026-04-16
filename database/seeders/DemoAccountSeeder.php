<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
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
            'Agama', 'UnitKerja', 'Instansi', 'Status',
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
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(array_merge($allPermissions, $shieldPermissions));

        // --- ADMIN: Semua kecuali Shield ---
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($allPermissions);

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

        // --- PENGAWAS: Read-only semua ---
        $pengawas = Role::firstOrCreate(['name' => 'pengawas', 'guard_name' => 'web']);
        $pengawasPermissions = [];
        foreach ($resources as $resource) {
            $pengawasPermissions[] = "ViewAny:{$resource}";
            $pengawasPermissions[] = "View:{$resource}";
        }
        $pengawas->syncPermissions($pengawasPermissions);

        // --- ANGGOTA: Tidak punya permission admin panel ---
        $anggota = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);
        // Anggota mengakses portal /member, bukan /admin
        $anggota->syncPermissions([]);

        // =====================================================
        // 3. BUAT AKUN DEMO (5 User)
        // =====================================================

        // Super Admin (sudah ada dari RoleSeeder, pastikan saja)
        $userSuperAdmin = User::firstOrCreate(
            ['email' => 'admin@kosipi.com'],
            ['name' => 'Super Administrator', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $userSuperAdmin->syncRoles('super_admin');

        // Admin
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin2@kosipi.com'],
            ['name' => 'Admin Koperasi', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $userAdmin->syncRoles('admin');

        // Bendahara
        $userBendahara = User::firstOrCreate(
            ['email' => 'bendahara@kosipi.com'],
            ['name' => 'Bendahara Koperasi', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $userBendahara->syncRoles('bendahara');

        // Pengawas
        $userPengawas = User::firstOrCreate(
            ['email' => 'pengawas@kosipi.com'],
            ['name' => 'Pengawas Koperasi', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $userPengawas->syncRoles('pengawas');

        // Anggota
        $userAnggota = User::firstOrCreate(
            ['email' => 'anggota@kosipi.com'],
            ['name' => 'Budi Anggota', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $userAnggota->syncRoles('anggota');
    }
}
