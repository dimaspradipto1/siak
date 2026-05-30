<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'gurus';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'nip_guru',
        'golongan',
        'pendidikan_terakhir',
    ];

    /**
     * Hubungan BelongsTo dengan model Pegawai.
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    /**
     * Hubungan HasMany dengan model CatatanSiswa.
     */
    public function catatanSiswa(): HasMany
    {
        return $this->hasMany(CatatanSiswa::class, 'guru_id');
    }

    /**
     * Hubungan HasMany dengan model WaliKelas.
     */
    public function waliKelas(): HasMany
    {
        return $this->hasMany(WaliKelas::class, 'guru_id');
    }
}
