<?php

namespace App\Imports;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NilaiImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $siswa = Siswa::where('nisn', $row['nisn'])->first();
        $mataPelajaran = MataPelajaran::where('nama_mata_pelajaran', $row['mata_pelajaran'])->first();
        $semester = Semester::where('nama_semester', $row['semester'])->first();
        $tahunAjaran = TahunAjaran::where('nama_tahun_ajaran', $row['tahun_ajaran'])->first();

        if ($siswa && $mataPelajaran && $semester && $tahunAjaran) {
            return Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mataPelajaran->id,
                    'semester_id' => $semester->id,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ],
                [
                    'nilai' => $row['nilai'],
                    'predikat' => $row['predikat'],
                ]
            );
        }
        return null;
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required',
            'mata_pelajaran' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'nilai' => 'required|numeric',
        ];
    }
}
