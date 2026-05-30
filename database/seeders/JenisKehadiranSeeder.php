<?php

namespace Database\Seeders;

use App\Models\JenisKehadiran;
use Illuminate\Database\Seeder;

class JenisKehadiranSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = [
            ['kode_kehadiran' => 'H', 'nama_kehadiran' => 'Hadir', 'keterangan' => 'Siswa hadir tepat waktu'],
            ['kode_kehadiran' => 'S', 'nama_kehadiran' => 'Sakit', 'keterangan' => 'Siswa tidak hadir karena sakit dengan surat dokter/izin'],
            ['kode_kehadiran' => 'I', 'nama_kehadiran' => 'Izin', 'keterangan' => 'Siswa tidak hadir karena keperluan keluarga yang disetujui'],
            ['kode_kehadiran' => 'A', 'nama_kehadiran' => 'Alpa', 'keterangan' => 'Siswa tidak hadir tanpa keterangan'],
            ['kode_kehadiran' => 'T', 'nama_kehadiran' => 'Terlambat', 'keterangan' => 'Siswa hadir melewati batas waktu'],
        ];

        foreach ($jenisList as $jenis) {
            JenisKehadiran::create($jenis);
        }
    }
}
