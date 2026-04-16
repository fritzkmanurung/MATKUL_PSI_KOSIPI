<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Sistem\Database\Factories\AgamaFactory;

class Agama extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['nama'];

    // protected static function newFactory(): AgamaFactory
    // {
    //     // return AgamaFactory::new();
    // }
}
