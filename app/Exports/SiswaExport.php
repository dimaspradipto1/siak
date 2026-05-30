<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Siswa::with(['kelas', 'orangTua'])->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'NIS',
            'Nama Siswa',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Alamat',
            'Nama Kelas',
            'Nama Ibu Kandung'
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nisn,
            $siswa->nis,
            $siswa->nama_siswa,
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir,
            $siswa->tanggal_lahir,
            $siswa->agama,
            $siswa->alamat,
            $siswa->kelas->nama_kelas ?? '',
            $siswa->orangTua->nama_ibu ?? ''
        ];
    }
}
