<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Hubungan HasMany dengan model WaliKelas.
     */
    public function waliKelas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WaliKelas::class, 'guru_id');
    }
}
