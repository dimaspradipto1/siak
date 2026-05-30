<?php

namespace App\Exports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MataPelajaranExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return MataPelajaran::all();
    }

    public function headings(): array
    {
        return [
            'Kode Mapel',
            'Nama Mapel',
            'KKM'
        ];
    }

    public function map($mapel): array
    {
        return [
            $mapel->kode_mapel,
            $mapel->nama_mapel,
            $mapel->kkm
        ];
    }
}
