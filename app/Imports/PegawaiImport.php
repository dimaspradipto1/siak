<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return Pegawai::updateOrCreate(
            ['nip' => $row['nipnik']], // Match nip/nik
            [
                'nama_pegawai'  => $row['nama_pegawai'],
                'jenis_kelamin' => $row['jenis_kelamin'] ?? 'Laki-Laki',
                'tempat_lahir'  => $row['tempat_lahir'] ?? null,
                'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                'no_hp'         => $row['no_hp'] ?? null,
                'alamat'        => $row['alamat'] ?? null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nipnik'       => 'required',
            'nama_pegawai' => 'required|string',
        ];
    }
}
