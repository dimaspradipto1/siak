<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Mata Pelajaran',
            'Semester',
            'Tahun Ajaran',
            'Nilai',
            'Predikat'
        ];
    }
}
