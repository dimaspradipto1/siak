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
        return Siswa::with(['kelas', 'orangTua', 'user'])->get();
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

    public function map($siswa): array
    {
        return [
            $siswa->nisn,
            $siswa->nama_siswa,
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir,
            $siswa->tgl_lahir,
            $siswa->agama,
            $siswa->nomor_wa,
            $siswa->alamat,
            $siswa->tgl_masuk,
            $siswa->status,
            $siswa->user->email ?? '',
            $siswa->orangTua->nama_ayah ?? '',
            $siswa->orangTua->pekerjaan_ayah ?? '',
            $siswa->orangTua->nomor_wa ?? '',
            $siswa->orangTua->nama_ibu ?? '',
            $siswa->orangTua->pekerjaan_ibu ?? '',
            $siswa->orangTua->nomor_wa_ibu ?? '',
            $siswa->orangTua->alamat ?? '',
            $siswa->orangTua->email ?? ''
        ];
    }
}
