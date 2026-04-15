<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define default roles
        $roles = [
            'super_admin', // Default Filament Shield Panel role
            'admin',
            'bendahara',
            'pengawas',
            'anggota',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Create initial super admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@kosipi.com'
        ], [
            'name' => 'Super Administrator',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('super_admin');
    }
}
