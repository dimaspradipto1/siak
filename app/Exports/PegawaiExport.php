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
        return Pegawai::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Pendidikan Terakhir',
            'Golongan',
            'Email',
            'Alamat Lengkap',
            'No Whatsapp',
            'Role',
            'Status',
        ];
    }

    public function map($pegawai): array
    {
        return [
            $pegawai->nip,
            $pegawai->nama_pegawai,
            $pegawai->jenis_kelamin,
            $pegawai->tempat_lahir,
            $pegawai->tgl_lahir ? $pegawai->tgl_lahir->format('Y-m-d') : '',
            $pegawai->agama,
            $pegawai->pendidikan_terakhir,
            $pegawai->golongan,
            $pegawai->user->email ?? '',
            $pegawai->alamat,
            $pegawai->nomor_wa,
            $pegawai->user->roles ?? strtolower($pegawai->jabatan),
            $pegawai->status,
        ];
    }
}
