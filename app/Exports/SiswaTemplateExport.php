<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'No Whatsapp',
            'Alamat',
            'Tanggal Masuk',
            'Status',
            'Email Siswa',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No Whatsapp Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No Whatsapp Ibu',
            'Alamat Orang Tua',
            'Email Orang Tua'
        ];
    }
}
