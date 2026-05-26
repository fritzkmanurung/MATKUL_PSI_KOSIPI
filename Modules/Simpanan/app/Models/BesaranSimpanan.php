<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BesaranSimpanan extends Model
{
    use HasFactory;

    protected $table = 'besaran_simpanans';
    protected $fillable = ['jenis_simpanan', 'nominal', 'is_aktif'];


    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    /**
     * Ambil nominal yang sedang aktif (hanya 1 yang boleh aktif per jenis_simpanan).
     */
    public static function getAktif(string $jenis = 'Wajib'): ?self
    {
        return static::where('is_aktif', true)
                     ->where('jenis_simpanan', $jenis)
                     ->first();
    }

    /**
     * Set nominal ini sebagai aktif, nonaktifkan semua yang lain untuk jenis yang sama.
     */
    public function setAktif(): void
    {
        static::where('id', '!=', $this->id)
              ->where('jenis_simpanan', $this->jenis_simpanan)
              ->update(['is_aktif' => false]);
              
        $this->update(['is_aktif' => true]);
    }

    /**
     * Boot: pastikan hanya 1 nominal aktif per jenis_simpanan saat create/update.
     */
    protected static function booted()
    {
        static::saving(function ($besaran) {
            if ($besaran->is_aktif) {
                static::where('id', '!=', $besaran->id)
                      ->where('jenis_simpanan', $besaran->jenis_simpanan)
                      ->update(['is_aktif' => false]);
            }
        });
    }
}
