<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MataPelajaranImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return MataPelajaran::updateOrCreate(
            ['kode_mapel' => $row['kode_mapel']],
            [
                'nama_mapel' => $row['nama_mapel'],
                'kkm'        => $row['kkm'] ?? 75,
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
