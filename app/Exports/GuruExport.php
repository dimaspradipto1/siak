<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuruExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Guru::with('pegawai')->get();
    }

    public function headings(): array
    {
        return [
            'NIP Pegawai',
            'NIP Guru',
            'Golongan',
            'Pendidikan Terakhir'
        ];
    }

    public function map($guru): array
    {
        return [
            $guru->pegawai->nip ?? '',
            $guru->nip_guru,
            $guru->golongan,
            $guru->pendidikan_terakhir
        ];
    }
}
