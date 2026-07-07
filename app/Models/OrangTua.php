<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        'nomor_wa_ibu',
        'alamat',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'email',
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
                $rawUsername = $orangTua->nomor_wa ?: 'ortu_' . $orangTua->id;
                $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($rawUsername));
                
                $user = User::create([
                    'name' => 'Ortu dari ' . ($orangTua->nama_ayah ?? 'Siswa'),
                    'username' => $username,
                    'email' => $username . '@gmail.com',
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
