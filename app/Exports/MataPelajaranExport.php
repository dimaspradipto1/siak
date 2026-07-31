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
            'KKM',
            'TP yang Optimal',
            'TP Yang Perlu Peningkatan',
        ];
    }

    public function map($mapel): array
    {
        return [
            $mapel->kode_mapel,
            $mapel->nama_mata_pelajaran,
            $mapel->kkm,
            $mapel->tp_optimal,
            $mapel->tp_peningkatan,
        ];
    }
}
