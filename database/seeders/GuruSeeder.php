<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'nip_pegawai'         => '197211151996021003',
                'nip_guru'            => '197211151996021003',
                'golongan'            => 'IV/a',
                'pendidikan_terakhir' => 'S1 PGSD',
            ],
            [
                'nip_pegawai'         => '197509202005022002',
                'nip_guru'            => '197509202005022002',
                'golongan'            => 'III/c',
                'pendidikan_terakhir' => 'S1 PGSD',
            ],
            [
                'nip_pegawai'         => '198004182008011012',
                'nip_guru'            => '198004182008011012',
                'golongan'            => 'III/b',
                'pendidikan_terakhir' => 'S1 PGSD',
            ],
            [
                'nip_pegawai'         => '198505122010122005',
                'nip_guru'            => '198505122010122005',
                'golongan'            => 'III/b',
                'pendidikan_terakhir' => 'S1 Pendidikan Agama Islam',
            ],
            [
                'nip_pegawai'         => '199109022015041003',
                'nip_guru'            => '199109022015041003',
                'golongan'            => 'III/a',
                'pendidikan_terakhir' => 'S1 Pendidikan Jasmani',
            ],
        ];

        foreach ($gurus as $guruData) {
            $pegawai = Pegawai::where('nip', $guruData['nip_pegawai'])->first();
            if ($pegawai) {
                Guru::updateOrCreate(
                    ['pegawai_id' => $pegawai->id],
                    [
                        'nip_guru'            => $guruData['nip_guru'],
                        'golongan'            => $guruData['golongan'],
                        'pendidikan_terakhir' => $guruData['pendidikan_terakhir'],
                    ]
                );
            }
        }
    }
}
