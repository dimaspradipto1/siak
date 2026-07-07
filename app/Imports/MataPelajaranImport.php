<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MataPelajaranImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $kelas = null;
        if (!empty($row['kelas'])) {
            $kelas = \App\Models\Kelas::where('nama_kelas', $row['kelas'])->first();
        }

        $tahunAjaran = null;
        if (!empty($row['tahun_ajaran'])) {
            $taParts = explode('/', $row['tahun_ajaran']);
            if (count($taParts) === 2) {
                $tahunAjaran = \App\Models\TahunAjaran::where('tahun_mulai', $taParts[0])
                    ->where('tahun_selesai', $taParts[1])
                    ->first();
            }
        }

        $semester = null;
        if (!empty($row['semester']) && $tahunAjaran) {
            $semester = \App\Models\Semester::where('nama_semester', $row['semester'])
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->first();
        }

        $guru = null;
        if (!empty($row['nama_guru'])) {
            $guru = \App\Models\Guru::whereHas('pegawai', function ($q) use ($row) {
                $q->where('nama_pegawai', 'like', '%' . $row['nama_guru'] . '%');
            })->first();
        }

        return MataPelajaran::updateOrCreate(
            [
                'kode_mapel'      => $row['kode_mapel'],
                'kelas_id'        => $kelas?->id,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'semester_id'     => $semester?->id,
            ],
            [
                'nama_mata_pelajaran' => $row['nama_mapel'],
                'kkm'                 => $row['kkm'] ?? 75,
                'guru_id'             => $guru?->id,
                'hari_mengajar'       => $row['hari_mengajar'] ?? null,
                'jam_mengajar'        => $row['jam_mengajar'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
        ];
    }
}
