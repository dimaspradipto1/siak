<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKehadiran extends Model
{
    use HasFactory;

    protected $table = 'jenis_kehadirans';

    protected $fillable = [
        'kode_kehadiran',
        'nama_kehadiran',
        'keterangan',
    ];

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'jenis_kehadiran_id');
    }
}
