<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Illuminate\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    /**
     * Seed data Wali Kelas untuk SD Negeri 007 Sekupang, Batam.
     */
    public function run(): void
    {
        // Ambil tahun ajaran aktif (2025/2026 yang kita set di seeder)
        $tahunAjaranAktif = TahunAjaran::where('status', 'Aktif')->first();
        
        if (!$tahunAjaranAktif) {
            return; // Jika tidak ada tahun ajaran aktif, skip
        }

        $gurus = Guru::all();
        $kelas = Kelas::all();

        // Assign wali kelas secara acak tapi berurutan, asumsi jumlah guru cukup
        $waliKelasList = [];
        $guruIndex = 0;

        foreach ($kelas as $k) {
            if (isset($gurus[$guruIndex])) {
                $waliKelasList[] = [
                    'guru_id'         => $gurus[$guruIndex]->id,
                    'kelas_id'        => $k->id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
                $guruIndex++;
            } else {
                break; // Jika guru habis
            }
        }

        WaliKelas::insert($waliKelasList);
    }
}
