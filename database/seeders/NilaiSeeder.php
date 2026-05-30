<?php

namespace Database\Seeders;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswaIds = Siswa::pluck('id')->toArray();
        $mapels = MataPelajaran::all();
        $semesterId = Semester::first()->id ?? null;
        $tahunAjaranId = TahunAjaran::first()->id ?? null;

        if (empty($siswaIds) || $mapels->isEmpty() || !$semesterId || !$tahunAjaranId) {
            return;
        }

        $nilaiList = [];

        // Pilih 10 siswa secara acak untuk diberi nilai dummy
        $selectedSiswa = $faker->randomElements($siswaIds, 10);

        foreach ($selectedSiswa as $siswaId) {
            // Setiap siswa mendapat nilai untuk 3 mapel acak
            $selectedMapels = $mapels->random(3);
            
            foreach ($selectedMapels as $mapel) {
                $nilaiAngka = $faker->randomFloat(2, 60, 100);
                
                // Tentukan predikat
                if ($nilaiAngka >= 90) {
                    $predikat = 'A';
                } elseif ($nilaiAngka >= 80) {
                    $predikat = 'B';
                } elseif ($nilaiAngka >= $mapel->kkm) {
                    $predikat = 'C';
                } else {
                    $predikat = 'D';
                }

                $nilaiList[] = [
                    'siswa_id'          => $siswaId,
                    'mata_pelajaran_id' => $mapel->id,
                    'semester_id'       => $semesterId,
                    'tahun_ajaran_id'   => $tahunAjaranId,
                    'nilai'             => $nilaiAngka,
                    'predikat'          => $predikat,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }
        }

        Nilai::insert($nilaiList);
    }
}
