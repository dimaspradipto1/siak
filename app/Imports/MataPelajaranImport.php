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
        if (empty($row['kode_mapel']) || empty($row['nama_mapel'])) {
            return null;
        }

        return MataPelajaran::updateOrCreate(
            [
                'kode_mapel' => $row['kode_mapel'],
            ],
            [
                'nama_mata_pelajaran' => $row['nama_mapel'],
                'kkm'                 => $row['kkm'] ?? 75,
                'tp_optimal'          => $row['tp_yang_optimal'] ?? null,
                'tp_peningkatan'      => $row['tp_yang_perlu_peningkatan'] ?? null,
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
