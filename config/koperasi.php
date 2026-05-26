<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pinjaman Configuration
    |--------------------------------------------------------------------------
    */
    'pinjaman' => [
        'multiplier_limit_pribadi' => 3,
        'multiplier_limit_likuiditas' => 0.20,
        'max_tenor_tetap' => 24,
        'max_tenor_kontrak' => 24,
        'min_masa_kontrak' => 2,
    ],

    /*
    |--------------------------------------------------------------------------
    | Simpanan Fallback Values
    |--------------------------------------------------------------------------
    */
    'simpanan' => [
        'default_pokok' => 100_000,
        'default_wajib' => 50_000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Role Names (Source of Truth)
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'superadmin' => 'superadmin',
        'ketua' => 'ketua',
        'sekretaris' => 'sekretaris',
        'bendahara' => 'bendahara',
        'anggota' => 'anggota',
        'admin_group' => ['superadmin', 'ketua', 'bendahara'],
        'pengurus_group' => ['superadmin', 'ketua', 'sekretaris', 'bendahara'],
    ],
];
