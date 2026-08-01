<?php

namespace App\Exports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MataPelajaranAktifExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return MataPelajaran::with(['kelas', 'tahunAjaran', 'semester', 'guru.pegawai'])
            ->whereNotNull('kelas_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Tahun Ajaran',
            'Semester',
            'Nama Mata Pelajaran',
            'Nama Guru',
            'Status',
            'Hari Mengajar',
            'Jam Mengajar'
        ];
    }

    public function map($mapel): array
    {
        $ta = $mapel->tahunAjaran ? ($mapel->tahunAjaran->tahun_mulai . '/' . $mapel->tahunAjaran->tahun_selesai) : '';
        return [
            $mapel->kelas?->nama_kelas ?? '',
            $ta,
            $mapel->semester?->nama_semester ?? '',
            $mapel->nama_mata_pelajaran,
            $mapel->guru?->pegawai?->nama_pegawai ?? '',
            $mapel->status ?? 'Aktif',
            $mapel->hari_mengajar ?? '',
            $mapel->jam_mengajar ?? ''
        ];
    }
}
