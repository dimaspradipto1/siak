<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Nilai::with(['siswa', 'mataPelajaran', 'semester', 'tahunAjaran'])->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Siswa',
            'Mata Pelajaran',
            'Semester',
            'Tahun Ajaran',
            'Nilai',
            'Predikat'
        ];
    }

    public function map($nilai): array
    {
        return [
            $nilai->siswa->nisn ?? '',
            $nilai->siswa->nama_siswa ?? '',
            $nilai->mataPelajaran->nama_mata_pelajaran ?? '',
            $nilai->semester->nama_semester ?? '',
            $nilai->tahunAjaran->nama_tahun_ajaran ?? '',
            $nilai->nilai,
            $nilai->predikat,
        ];
    }
}
