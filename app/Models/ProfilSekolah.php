<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $table = 'profil_sekolahs';

    protected $fillable = [
        'nama_sekolah',
        'nis_nss_nds',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'alamat_sekolah',
        'kelurahan_desa',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'tanggal_berdiri',
        'tahun_ajaran_id',
        'no_telephone',
        'email',
        'status',
        'logo_sekolah',
        'deskripsi',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
