<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahunAjaran extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'tahun_ajarans';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun_mulai',
        'tahun_selesai',
        'status',
    ];

    /**
     * Casting atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_mulai'   => 'integer',
        'tahun_selesai' => 'integer',
    ];

    /**
     * Accessor: Menampilkan format "2024/2025".
     */
    public function getNamaTahunAjaranAttribute(): string
    {
        return $this->tahun_mulai . '/' . $this->tahun_selesai;
    }
}
