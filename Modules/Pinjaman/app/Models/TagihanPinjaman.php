<?php

namespace Modules\Pinjaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Pinjaman\Database\Factories\TagihanPinjamanFactory;

class TagihanPinjaman extends Model
{
    use HasFactory;

    protected $table = 'tagihan_pinjamans';
    protected $guarded = [];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TagihanPinjamanFactory
    // {
    //     // return TagihanPinjamanFactory::new();
    // }
}
