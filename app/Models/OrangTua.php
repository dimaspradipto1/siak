<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tuas';

    protected $fillable = [
        'user_id',
        'nama_ayah',
        'nama_ibu',
        'nomor_wa',
        'alamat',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'orang_tua_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($orangTua) {
            if (!$orangTua->user_id) {
                $username = $orangTua->nomor_wa ?: 'ortu_' . $orangTua->id;
                $user = User::create([
                    'name' => 'Ortu dari ' . ($orangTua->nama_ayah ?? 'Siswa'),
                    'username' => $username,
                    'email' => $username . '@ortu.siak.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'roles' => 'orang tua',
                    'is_active' => true,
                ]);
                $orangTua->user_id = $user->id;
                $orangTua->saveQuietly();
            }
        });
    }
}
