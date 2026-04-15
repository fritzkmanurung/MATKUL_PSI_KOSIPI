<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Sistem\Database\Factories\UnitKerjaFactory;

class UnitKerja extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): UnitKerjaFactory
    // {
    //     // return UnitKerjaFactory::new();
    // }
}
