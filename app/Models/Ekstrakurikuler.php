<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikulers';

    protected $fillable = [
        'nama_ekskul',
        'keterangan',
        'pembina',
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'ekstrakurikuler_id');
    }
}
