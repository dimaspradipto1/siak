<?php

namespace App\Exports;

use App\Models\OrangTua;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrangTuaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return OrangTua::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Username Akun',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No HP Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No HP Ibu',
            'Alamat'
        ];
    }

    public function map($orangtua): array
    {
        return [
            $orangtua->user->username ?? '',
            $orangtua->nama_ayah,
            $orangtua->pekerjaan_ayah,
            $orangtua->no_hp_ayah,
            $orangtua->nama_ibu,
            $orangtua->pekerjaan_ibu,
            $orangtua->no_hp_ibu,
            $orangtua->alamat
        ];
    }
}
