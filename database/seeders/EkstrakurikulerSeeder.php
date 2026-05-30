<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Seed data Ekstrakurikuler SD Negeri 007 Sekupang.
     */
    public function run(): void
    {
        $ekskulList = [
            [
                'nama_ekskul' => 'Pramuka',
                'keterangan'  => 'Wajib untuk kelas 3 - 6. Setiap hari Sabtu Pukul 14.00',
                'pembina'     => 'Budi Santoso, S.Pd',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_ekskul' => 'PMR (Palang Merah Remaja)',
                'keterangan'  => 'Setiap hari Jumat Pukul 14.00',
                'pembina'     => 'Siti Aminah, S.Kep',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_ekskul' => 'Futsal',
                'keterangan'  => 'Setiap hari Rabu Pukul 15.30 di Lapangan Sekolah',
                'pembina'     => 'Agus Salim, S.Pd',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_ekskul' => 'Tari Tradisional',
                'keterangan'  => 'Setiap hari Selasa Pukul 14.00 di Aula',
                'pembina'     => 'Ratna Sari, S.Sn',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_ekskul' => 'Rohis / BTA',
                'keterangan'  => 'Setiap hari Jumat Pukul 13.00 di Musholla',
                'pembina'     => 'Ahmad Fauzi, S.Pd.I',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        Ekstrakurikuler::insert($ekskulList);
    }
}
