<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisCatatan extends Model
{
    use HasFactory;

    protected $table = 'jenis_catatans';

    protected $fillable = [
        'kode',
        'nama_jenis_catatan',
        'keterangan',
    ];

    public function catatanSiswa(): HasMany
    {
        return $this->hasMany(CatatanSiswa::class, 'jenis_catatan_id');
    }
}
