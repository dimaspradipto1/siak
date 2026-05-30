<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapelList = [
            ['nama_mata_pelajaran' => 'Pendidikan Agama Islam', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Bahasa Indonesia', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Matematika', 'kkm' => 70],
            ['nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam', 'kkm' => 70],
            ['nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Seni Budaya dan Prakarya', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kkm' => 75],
            ['nama_mata_pelajaran' => 'Bahasa Inggris', 'kkm' => 70],
        ];

        foreach ($mapelList as $mapel) {
            MataPelajaran::create($mapel);
        }
    }
}
