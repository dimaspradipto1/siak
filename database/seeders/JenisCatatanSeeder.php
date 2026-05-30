<?php

namespace Database\Seeders;

use App\Models\JenisCatatan;
use Illuminate\Database\Seeder;

class JenisCatatanSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = [
            ['kode' => 1, 'nama_jenis_catatan' => 'Prestasi Akademik', 'keterangan' => 'Pencapaian di bidang akademik'],
            ['kode' => 2, 'nama_jenis_catatan' => 'Prestasi Non-Akademik', 'keterangan' => 'Pencapaian di bidang non-akademik (olahraga, seni, dll)'],
            ['kode' => 3, 'nama_jenis_catatan' => 'Pelanggaran Ringan', 'keterangan' => 'Pelanggaran kedisiplinan ringan'],
            ['kode' => 4, 'nama_jenis_catatan' => 'Pelanggaran Sedang', 'keterangan' => 'Pelanggaran kedisiplinan tingkat menengah'],
            ['kode' => 5, 'nama_jenis_catatan' => 'Pelanggaran Berat', 'keterangan' => 'Pelanggaran kedisiplinan tingkat berat'],
        ];

        foreach ($jenisList as $jenis) {
            JenisCatatan::create($jenis);
        }
    }
}
