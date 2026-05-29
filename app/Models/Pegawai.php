<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'pegawais';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nama_pegawai',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'jabatan',
        'agama',
        'nomor_wa',
        'alamat',
    ];

    /**
     * Dapatkan cast untuk tipe atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
        ];
    }

    /**
     * Hubungan HasOne dengan model Guru.
     */
    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'pegawai_id');
    }
}
