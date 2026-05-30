<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrangTuaSeeder extends Seeder
{
    /**
     * Seed data Orang Tua untuk SD Negeri 007 Sekupang, Batam.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $orangTuasList = [];

        // Membuat 50 data orang tua dummy
        for ($i = 1; $i <= 50; $i++) {
            $orangTuasList[] = [
                'nama_ayah'      => $faker->firstNameMale . ' ' . $faker->lastName,
                'nama_ibu'       => $faker->firstNameFemale . ' ' . $faker->lastName,
                'nomor_wa'       => $faker->phoneNumber,
                'alamat'         => 'Jl. Sekupang Baru No. ' . $faker->buildingNumber . ', Batam',
                'pekerjaan_ayah' => $faker->randomElement(['Wiraswasta', 'PNS', 'Karyawan Swasta', 'TNI/Polri', 'Buruh']),
                'pekerjaan_ibu'  => $faker->randomElement(['Ibu Rumah Tangga', 'Guru', 'PNS', 'Pedagang']),
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        OrangTua::insert($orangTuasList);
    }
}
