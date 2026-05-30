<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'semesters';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun_ajaran_id',
        'nama_semester',
    ];

    /**
     * Hubungan BelongsTo dengan model TahunAjaran.
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Accessor: Menampilkan format "Semester 1 - 2024/2025".
     */
    public function getNamaLengkapAttribute(): string
    {
        $ta = $this->tahunAjaran;
        return $this->nama_semester . ' - ' . ($ta ? $ta->nama_tahun_ajaran : '-');
    }
}
