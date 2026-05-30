<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $pegawai = Pegawai::where('nip', $row['nip_pegawai'])->first();
        if (!$pegawai) {
            return null; // Skip if pegawai not found
        }

        return Guru::updateOrCreate(
            ['pegawai_id' => $pegawai->id],
            [
                'nip_guru'            => $row['nip_guru'],
                'golongan'            => $row['golongan'],
                'pendidikan_terakhir' => $row['pendidikan_terakhir'],
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nip_pegawai' => 'required|exists:pegawais,nip',
        ];
    }
}
