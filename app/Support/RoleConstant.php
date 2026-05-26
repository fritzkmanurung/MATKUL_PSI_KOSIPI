<?php

namespace App\Support;

/**
 * Centralized role name definitions to prevent typos and mismatches.
 */
final class RoleConstant
{
    public const SUPERADMIN = 'superadmin';
    public const KETUA = 'ketua';
    public const SEKRETARIS = 'sekretaris';
    public const BENDAHARA = 'bendahara';
    public const ANGGOTA = 'anggota';

    /**
     * Roles that can access the admin panel and receive admin notifications.
     */
    public static function adminRoles(): array
    {
        return [
            self::SUPERADMIN,
            self::KETUA,
            self::BENDAHARA,
        ];
    }

    /**
     * All management roles (including sekretaris).
     */
    public static function pengurusRoles(): array
    {
        return [
            self::SUPERADMIN,
            self::KETUA,
            self::SEKRETARIS,
            self::BENDAHARA,
        ];
    }
}
