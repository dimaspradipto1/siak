<?php

namespace App\Imports;

use App\Models\OrangTua;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrangTuaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $user = null;
        if (!empty($row['username_akun'])) {
            $user = User::where('username', $row['username_akun'])->first();
        }

        return OrangTua::updateOrCreate(
            ['nama_ayah' => $row['nama_ayah'], 'nama_ibu' => $row['nama_ibu']], // Unik berdasarkan ayah dan ibu (atau bs via user_id)
            [
                'user_id'        => $user ? $user->id : null,
                'pekerjaan_ayah' => $row['pekerjaan_ayah'],
                'no_hp_ayah'     => $row['no_hp_ayah'],
                'pekerjaan_ibu'  => $row['pekerjaan_ibu'],
                'no_hp_ibu'      => $row['no_hp_ibu'],
                'alamat'         => $row['alamat'],
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_ayah' => 'required',
            'nama_ibu'  => 'required',
        ];
    }
}
