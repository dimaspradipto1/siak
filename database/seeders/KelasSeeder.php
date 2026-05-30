<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Seed data Kelas untuk SD Negeri 007 Sekupang, Batam.
     * Kelas 1 sampai 6, masing-class ada 2 kelas (A dan B)
     */
    public function run(): void
    {
        $kelasList = [];

        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            $kelasList[] = [
                'nama_kelas' => $tingkat . ' A',
                'tingkat'    => (string) $tingkat,
                'ruangan'    => 'Ruang ' . $tingkat . 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $kelasList[] = [
                'nama_kelas' => $tingkat . ' B',
                'tingkat'    => (string) $tingkat,
                'ruangan'    => 'Ruang ' . $tingkat . 'B',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Kelas::insert($kelasList);
    }
}
