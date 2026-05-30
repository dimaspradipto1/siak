<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Seed data Tahun Ajaran untuk SD Negeri 007 Sekupang, Batam.
     *
     * Tahun ajaran mengikuti kalender pendidikan nasional
     * yang ditetapkan Kemendikbud: Juli – Juni.
     */
    public function run(): void
    {
        $tahunAjarans = [
            [
                'tahun_mulai'   => 2020,
                'tahun_selesai' => 2021,
                'status'        => 'Tidak Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'tahun_mulai'   => 2021,
                'tahun_selesai' => 2022,
                'status'        => 'Tidak Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'tahun_mulai'   => 2022,
                'tahun_selesai' => 2023,
                'status'        => 'Tidak Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'tahun_mulai'   => 2023,
                'tahun_selesai' => 2024,
                'status'        => 'Tidak Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'tahun_mulai'   => 2024,
                'tahun_selesai' => 2025,
                'status'        => 'Tidak Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'tahun_mulai'   => 2025,
                'tahun_selesai' => 2026,
                'status'        => 'Aktif',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        TahunAjaran::insert($tahunAjarans);
    }
}
