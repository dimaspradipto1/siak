<?php

namespace Database\Seeders;

use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\JenisKehadiran;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KehadiranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswaIds = Siswa::pluck('id')->toArray();
        $mapelIds = MataPelajaran::pluck('id')->toArray();
        $jenisHadirIds = JenisKehadiran::where('kode_kehadiran', 'H')->pluck('id')->toArray();
        $jenisLainIds = JenisKehadiran::where('kode_kehadiran', '!=', 'H')->pluck('id')->toArray();

        if (empty($siswaIds) || empty($mapelIds) || empty($jenisHadirIds)) {
            return;
        }

        $kehadiranList = [];

        // Buat 50 data dummy kehadiran
        for ($i = 0; $i < 50; $i++) {
            // 80% kemungkinan Hadir, 20% izin/sakit/alpa
            $isHadir = $faker->boolean(80);
            $jenisId = $isHadir ? $jenisHadirIds[0] : $faker->randomElement($jenisLainIds);

            $kehadiranList[] = [
                'jenis_kehadiran_id' => $jenisId,
                'mata_pelajaran_id'  => $faker->randomElement($mapelIds),
                'siswa_id'           => $faker->randomElement($siswaIds),
                'tanggal'            => date('Y-m-d', strtotime('-' . rand(0, 30) . ' days')),
                'keterangan'         => $isHadir ? null : $faker->sentence(3),
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        Kehadiran::insert($kehadiranList);
    }
}
