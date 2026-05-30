<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanSiswa extends Model
{
    use HasFactory;

    protected $table = 'catatan_siswas';

    protected $fillable = [
        'jenis_catatan_id',
        'siswa_id',
        'guru_id',
        'semester_id',
        'tahun_ajaran_id',
        'tanggal',
        'isi_catatan',
        'tindak_lanjut',
        'status',
    ];

    public function jenisCatatan(): BelongsTo
    {
        return $this->belongsTo(JenisCatatan::class, 'jenis_catatan_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
