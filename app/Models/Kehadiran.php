<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadirans';

    protected $fillable = [
        'jenis_kehadiran_id',
        'mata_pelajaran_id',
        'siswa_id',
        'tanggal',
        'keterangan',
    ];

    public function jenisKehadiran(): BelongsTo
    {
        return $this->belongsTo(JenisKehadiran::class, 'jenis_kehadiran_id');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
