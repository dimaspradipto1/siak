<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Seed data Siswa untuk SD Negeri 007 Sekupang, Batam.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kelasIds = Kelas::pluck('id')->toArray();
        $orangTuaIds = OrangTua::pluck('id')->toArray();
        $ekskulIds = Ekstrakurikuler::pluck('id')->toArray();

        if (empty($kelasIds) || empty($orangTuaIds)) {
            return; // Pastikan data master ada
        }

        $siswaList = [];

        // Membuat 100 siswa dummy
        for ($i = 1; $i <= 100; $i++) {
            $jk = $faker->randomElement(['Laki-laki', 'Perempuan']);
            
            // Pilih satu orang tua
            $orangTuaId = $faker->randomElement($orangTuaIds);

            // Opsional ekskul
            $ekskulId = $faker->boolean(70) ? $faker->randomElement($ekskulIds) : null;

            $siswaList[] = [
                'orang_tua_id'       => $orangTuaId,
                'kelas_id'           => $faker->randomElement($kelasIds),
                'ekstrakurikuler_id' => $ekskulId,
                'nisn'               => '00' . $faker->unique()->randomNumber(8, true),
                'nama_siswa'         => $jk == 'Laki-laki' ? $faker->firstNameMale . ' ' . $faker->lastName : $faker->firstNameFemale . ' ' . $faker->lastName,
                'jenis_kelamin'      => $jk,
                'tempat_lahir'       => $faker->city,
                'tgl_lahir'          => $faker->dateTimeBetween('-12 years', '-6 years')->format('Y-m-d'),
                'agama'              => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'nomor_wa'           => $faker->boolean(50) ? $faker->phoneNumber : null,
                'alamat'             => 'Komp. ' . $faker->streetName . ' No. ' . $faker->buildingNumber . ', Sekupang, Batam',
                'tgl_masuk'          => $faker->dateTimeBetween('-6 years', 'now')->format('Y-m-d'),
                'status'             => 'Aktif',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        // Chunk insert untuk performa
        foreach (array_chunk($siswaList, 50) as $chunk) {
            Siswa::insert($chunk);
        }
    }
}
