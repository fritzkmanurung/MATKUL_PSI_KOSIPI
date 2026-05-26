<?php

namespace Modules\Keanggotaan\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Sistem\Models\Agama;
use Modules\Sistem\Models\Instansi;
use Modules\Sistem\Models\Status;
use Modules\Sistem\Models\UnitKerja;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'nba', 'nip', 'nik', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_hp', 'status_perkawinan',
        'nama_suami_istri', 'agama_id', 'unit_kerja_id', 'instansi_id',
        'status_id', 'foto_profil', 'tanggal_bergabung', 'is_aktif',
        'nama_ahli_waris', 'hubungan_ahli_waris',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
