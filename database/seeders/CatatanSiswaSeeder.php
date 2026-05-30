<?php

namespace Database\Seeders;

use App\Models\CatatanSiswa;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\JenisCatatan;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CatatanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $siswaIds = Siswa::pluck('id')->toArray();
        $guruIds = Guru::pluck('id')->toArray();
        $jenisCatatanIds = JenisCatatan::pluck('id')->toArray();
        $semesterId = Semester::first()->id ?? null;
        $tahunAjaranId = TahunAjaran::first()->id ?? null;

        if (empty($siswaIds) || empty($guruIds) || empty($jenisCatatanIds) || !$semesterId || !$tahunAjaranId) {
            return;
        }

        $catatanList = [];
        $statusOptions = ['Belum Diproses', 'Sedang Diproses', 'Selesai'];

        for ($i = 0; $i < 20; $i++) {
            $catatanList[] = [
                'jenis_catatan_id' => $faker->randomElement($jenisCatatanIds),
                'siswa_id'         => $faker->randomElement($siswaIds),
                'guru_id'          => $faker->randomElement($guruIds),
                'semester_id'      => $semesterId,
                'tahun_ajaran_id'  => $tahunAjaranId,
                'tanggal'          => date('Y-m-d', strtotime('-' . rand(0, 30) . ' days')),
                'isi_catatan'      => $faker->sentence(10),
                'tindak_lanjut'    => $faker->boolean(70) ? $faker->sentence(5) : null,
                'status'           => $faker->randomElement($statusOptions),
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        CatatanSiswa::insert($catatanList);
    }
}
