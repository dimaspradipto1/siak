<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = \App\Models\Kelas::all();
        $semesterList = \App\Models\Semester::all();
        $guruList = \App\Models\Guru::all();
        $tahunAjaranList = \App\Models\TahunAjaran::all();

        if ($kelasList->isEmpty() || $semesterList->isEmpty() || $guruList->isEmpty() || $tahunAjaranList->isEmpty()) {
            return;
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $times = ['07:30 - 09:00', '09:30 - 11:00', '11:00 - 12:30'];

        $mapelTemplates = [
            ['kode_mapel' => 'MP001', 'nama_mata_pelajaran' => 'Pendidikan Agama Islam', 'kkm' => 75, 'tp_optimal' => 'Memahami rukun Islam dan rukun iman secara mendalam.', 'tp_peningkatan' => 'Perlu meningkatkan hafalan surat-surat pendek.'],
            ['kode_mapel' => 'MP002', 'nama_mata_pelajaran' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kkm' => 75, 'tp_optimal' => 'Menerapkan nilai-nilai Pancasila dalam kehidupan sehari-hari.', 'tp_peningkatan' => 'Perlu pemahaman lebih lanjut mengenai hak dan kewajiban warga negara.'],
            ['kode_mapel' => 'MP003', 'nama_mata_pelajaran' => 'Bahasa Indonesia', 'kkm' => 75, 'tp_optimal' => 'Mampu membaca dan memahami teks bacaan dengan baik.', 'tp_peningkatan' => 'Perlu bimbingan dalam menyusun kalimat efektif dan ejaan yang disempurnakan.'],
            ['kode_mapel' => 'MP004', 'nama_mata_pelajaran' => 'Matematika', 'kkm' => 70, 'tp_optimal' => 'Sangat terampil dalam melakukan operasi hitung penjumlahan dan pengurangan.', 'tp_peningkatan' => 'Perlu latihan lebih lanjut dalam pemecahan masalah soal cerita.'],
            ['kode_mapel' => 'MP005', 'nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam', 'kkm' => 70, 'tp_optimal' => 'Memahami siklus hidup makhluk hidup dengan sangat baik.', 'tp_peningkatan' => 'Perlu peningkatan dalam melakukan eksperimen/praktikum mandiri.'],
            ['kode_mapel' => 'MP006', 'nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial', 'kkm' => 75, 'tp_optimal' => 'Mengenal keragaman sosial budaya di lingkungan sekitar.', 'tp_peningkatan' => 'Perlu memahami peta wilayah dan pembagian administratif.'],
            ['kode_mapel' => 'MP007', 'nama_mata_pelajaran' => 'Seni Budaya dan Prakarya', 'kkm' => 75, 'tp_optimal' => 'Sangat kreatif dalam membuat prakarya dari bahan alam.', 'tp_peningkatan' => 'Perlu berlatih teknik bernyanyi dengan intonasi yang tepat.'],
            ['kode_mapel' => 'MP008', 'nama_mata_pelajaran' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'kkm' => 75, 'tp_optimal' => 'Menunjukkan kebugaran jasmani yang baik dan menguasai teknik dasar atletik.', 'tp_peningkatan' => 'Perlu memperhatikan keselamatan diri saat beraktivitas fisik.'],
            ['kode_mapel' => 'MP009', 'nama_mata_pelajaran' => 'Bahasa Inggris', 'kkm' => 70, 'tp_optimal' => 'Mampu berkomunikasi sederhana dan memahami kosakata dasar.', 'tp_peningkatan' => 'Perlu meningkatkan kemampuan tata bahasa (grammar).'],
        ];

        $index = 0;
        foreach ($kelasList as $kelas) {
            foreach ($semesterList as $semester) {
                foreach ($mapelTemplates as $template) {
                    $guru = $guruList[$index % $guruList->count()];
                    $day = $days[$index % count($days)];
                    $time = $times[$index % count($times)];

                    MataPelajaran::create(array_merge($template, [
                        'kelas_id'        => $kelas->id,
                        'tahun_ajaran_id' => $semester->tahun_ajaran_id,
                        'semester_id'     => $semester->id,
                        'guru_id'         => $guru->id,
                        'hari_mengajar'   => $day,
                        'jam_mengajar'    => $time,
                    ]));
                    $index++;
                }
            }
        }
    }
}
