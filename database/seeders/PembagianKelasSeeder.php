<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\PembagianKelas;
use Illuminate\Database\Seeder;

class PembagianKelasSeeder extends Seeder
{
    public function run(): void
    {
        $activeTahunAjaran = TahunAjaran::where('status', 'Aktif')->first() ?? TahunAjaran::first();
        if (!$activeTahunAjaran) {
            return;
        }

        $siswas = Siswa::all();
        foreach ($siswas as $siswa) {
            if ($siswa->kelas_id) {
                PembagianKelas::updateOrCreate(
                    [
                        'siswa_id'        => $siswa->id,
                        'tahun_ajaran_id' => $activeTahunAjaran->id,
                    ],
                    [
                        'kelas_id'        => $siswa->kelas_id,
                    ]
                );
            }
        }
    }
}
