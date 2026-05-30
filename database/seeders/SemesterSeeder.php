<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Seed data Semester untuk SD Negeri 007 Sekupang, Batam.
     *
     * Setiap tahun ajaran memiliki 2 semester:
     * - Semester 1 (Ganjil): Juli – Desember
     * - Semester 2 (Genap): Januari – Juni
     *
     * Mengikuti kalender pendidikan nasional Kemendikbud.
     */
    public function run(): void
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai')->get();

        $semesters = [];

        foreach ($tahunAjarans as $ta) {
            $semesters[] = [
                'tahun_ajaran_id' => $ta->id,
                'nama_semester'   => 'Semester 1 (Ganjil)',
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
            $semesters[] = [
                'tahun_ajaran_id' => $ta->id,
                'nama_semester'   => 'Semester 2 (Genap)',
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        Semester::insert($semesters);
    }
}
