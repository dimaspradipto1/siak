<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tuas';

    protected $fillable = [
        'nama_ayah',
        'nama_ibu',
        'nomor_wa',
        'alamat',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }
}
