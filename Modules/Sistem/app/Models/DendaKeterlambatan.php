<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Simpanan\Database\Factories\DendaKeterlambatanFactory;

class DendaKeterlambatan extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_denda', 'nominal_denda', 'is_aktif'];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->is_aktif) {
                static::where('id', '!=', $model->id)
                    ->where('jenis_denda', $model->jenis_denda)
                    ->update(['is_aktif' => false]);
            }
        });
    }

    public static function getAktif(string $jenis = 'Simpanan Wajib')
    {
        return static::where('is_aktif', true)
            ->where('jenis_denda', $jenis)
            ->first();
    }

    // protected static function newFactory(): DendaKeterlambatanFactory
    // {
    //     // return DendaKeterlambatanFactory::new();
    // }
}
