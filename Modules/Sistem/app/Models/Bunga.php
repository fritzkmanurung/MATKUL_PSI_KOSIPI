<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bunga extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    /**
     * Ambil bunga yang sedang aktif (hanya 1 yang boleh aktif).
     */
    public static function getAktif(): ?self
    {
        return static::where('is_aktif', true)->first();
    }

    /**
     * Set bunga ini sebagai aktif, nonaktifkan semua yang lain.
     */
    public function setAktif(): void
    {
        static::where('id', '!=', $this->id)->update(['is_aktif' => false]);
        $this->update(['is_aktif' => true]);
    }

    /**
     * Boot: pastikan hanya 1 bunga aktif saat create/update.
     */
    protected static function booted()
    {
        static::saving(function ($bunga) {
            if ($bunga->is_aktif) {
                static::where('id', '!=', $bunga->id)->update(['is_aktif' => false]);
            }
        });
    }
}
