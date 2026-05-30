<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PegawaiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pegawai::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'NIP/NIK',
            'Nama Pegawai',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'No HP',
            'Alamat',
        ];
    }

    public function map($pegawai): array
    {
        return [
            $pegawai->id,
            $pegawai->nip,
            $pegawai->nama_pegawai,
            $pegawai->jenis_kelamin,
            $pegawai->tempat_lahir,
            $pegawai->tanggal_lahir,
            $pegawai->no_hp,
            $pegawai->alamat,
        ];
    }
}
