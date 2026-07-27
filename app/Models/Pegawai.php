<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_pegawai',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'jabatan',
        'golongan',
        'pendidikan_terakhir',
        'status',
        'agama',
        'nomor_wa',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class, 'pegawai_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pegawai) {
            if (!$pegawai->user_id) {
                $rawUsername = $pegawai->nip ?: 'pegawai_' . $pegawai->id;
                $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($rawUsername));
                
                $user = User::create([
                    'name' => $pegawai->nama_pegawai,
                    'username' => $username,
                    'email' => $username . '@gmail.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'roles' => 'pegawai',
                    'is_active' => true,
                ]);
                $pegawai->user_id = $user->id;
                $pegawai->saveQuietly();
            }
        });
    }
}
