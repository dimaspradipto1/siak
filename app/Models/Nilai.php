<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'semester_id',
        'tahun_ajaran_id',
        
        'lm1_tp1', 'lm1_tp2', 'lm1_tp3', 'lm1_tp4', 'lm1',
        'lm2_tp1', 'lm2_tp2', 'lm2_tp3', 'lm2_tp4', 'lm2',
        'lm3_tp1', 'lm3_tp2', 'lm3_tp3', 'lm3_tp4', 'lm3',
        'lm4_tp1', 'lm4_tp2', 'lm4_tp3', 'lm4_tp4', 'lm4',
        'lm5_tp1', 'lm5_tp2', 'lm5_tp3', 'lm5_tp4', 'lm5',
        
        'nilai_harian',
        'nilai_mid',
        'nilai_mid_plus',
        'nilai_pas',
        'nilai_pas_plus',
        'nilai_raport',

        'nilai',
        'predikat',
    ];

    public static function hitungPredikat($nilai): string
    {
        if ($nilai >= 85) {
            return 'A';
        }
        if ($nilai >= 75) {
            return 'B';
        }
        if ($nilai >= 60) {
            return 'C';
        }
        return 'D';
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
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
