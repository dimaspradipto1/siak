<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            return;
        }

        $pengumumanList = [];

        for ($i = 0; $i < 5; $i++) {
            $pengumumanList[] = [
                'user_id'    => $faker->randomElement($userIds),
                'judul'      => $faker->sentence(4),
                'keterangan' => $faker->paragraph(4),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Pengumuman::insert($pengumumanList);
    }
}
