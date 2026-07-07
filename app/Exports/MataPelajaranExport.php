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
        return MataPelajaran::with(['kelas', 'tahunAjaran', 'semester', 'guru.pegawai'])->get();
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Tahun Ajaran',
            'Semester',
            'Kode Mapel',
            'Nama Mapel',
            'KKM',
            'Nama Guru',
            'Hari Mengajar',
            'Jam Mengajar',
        ];
    }

    public function map($mapel): array
    {
        return [
            $mapel->kelas?->nama_kelas ?? '-',
            $mapel->tahunAjaran?->nama_tahun_ajaran ?? '-',
            $mapel->semester?->nama_semester ?? '-',
            $mapel->kode_mapel,
            $mapel->nama_mata_pelajaran,
            $mapel->kkm,
            $mapel->guru?->pegawai?->nama_pegawai ?? '-',
            $mapel->hari_mengajar ?? '-',
            $mapel->jam_mengajar ?? '-',
        ];
    }
}
