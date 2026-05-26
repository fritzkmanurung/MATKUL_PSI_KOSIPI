<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenggatWaktu extends Model
{
    use HasFactory;

    protected $table = 'tenggat_waktus';
    protected $fillable = ['jenis_tagihan', 'tanggal_mulai', 'tanggal_akhir', 'is_aktif'];


    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->is_aktif) {
                static::where('id', '!=', $model->id)
                      ->where('jenis_tagihan', $model->jenis_tagihan)
                      ->update(['is_aktif' => false]);
            }
        });
    }

    public static function getAktif(string $jenis = 'Simpanan')
    {
        return static::where('is_aktif', true)
                     ->where('jenis_tagihan', $jenis)
                     ->first();
    }
}
