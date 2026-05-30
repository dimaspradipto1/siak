<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\OrangTua;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $kelas = null;
        if (!empty($row['nama_kelas'])) {
            $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        }

        $orangTua = null;
        if (!empty($row['nama_ibu_kandung'])) {
            $orangTua = OrangTua::where('nama_ibu', $row['nama_ibu_kandung'])->first();
        }

        return Siswa::updateOrCreate(
            ['nisn' => $row['nisn']],
            [
                'nis'           => $row['nis'],
                'nama_siswa'    => $row['nama_siswa'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? 'Laki-Laki',
                'tempat_lahir'  => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'agama'         => $row['agama'] ?? 'Islam',
                'alamat'        => $row['alamat'],
                'kelas_id'      => $kelas ? $kelas->id : null,
                'orang_tua_id'  => $orangTua ? $orangTua->id : null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nisn'       => 'required',
            'nama_siswa' => 'required',
        ];
    }
}
