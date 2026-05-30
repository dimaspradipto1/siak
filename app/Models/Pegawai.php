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
        'user_id',
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

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan HasOne dengan model Guru.
     */
    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'pegawai_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pegawai) {
            if (!$pegawai->user_id) {
                $username = $pegawai->nip ?: 'pegawai_' . $pegawai->id;
                $user = User::create([
                    'name' => $pegawai->nama_pegawai,
                    'username' => $username,
                    'email' => $username . '@siak.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'roles' => 'pegawai', // Default, can be updated later if they become a Guru
                    'is_active' => true,
                ]);
                $pegawai->user_id = $user->id;
                $pegawai->saveQuietly();
            }
        });
    }
}
