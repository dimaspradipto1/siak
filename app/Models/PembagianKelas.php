<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembagianKelas extends Model
{
    protected $table = 'pembagian_kelas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function getWaliKelasNamaAttribute()
    {
        $wali = \App\Models\WaliKelas::where('kelas_id', $this->kelas_id)
            ->where('tahun_ajaran_id', $this->tahun_ajaran_id)
            ->first();
        return $wali && $wali->guru && $wali->guru->pegawai 
            ? $wali->guru->pegawai->nama_pegawai 
            : '-';
    }
}
