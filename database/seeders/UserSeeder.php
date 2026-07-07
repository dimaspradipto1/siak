<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name'      => 'Administrator',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('admin1234'),
                'roles'     => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Budi Santoso, S.Pd.',
                'email'     => 'guru@gmail.com',
                'password'  => Hash::make('guru1234'),
                'roles'     => 'guru',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Siti Aminah, S.Pd.I',
                'email'     => 'walikelas@gmail.com',
                'password'  => Hash::make('walikelas1234'),
                'roles'     => 'wali kelas',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Yusal, S.Pd.',
                'email'     => 'kepsek@gmail.com',
                'password'  => Hash::make('kepsek1234'),
                'roles'     => 'kepala sekolah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Suparman',
                'email'     => 'orangtua@gmail.com',
                'password'  => Hash::make('orangtua1234'),
                'roles'     => 'orang tua',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $siswaNames = [
            'ALIYA PASILLA',
            "ALL'VIE RASYHA MAHENDRA",
            'AQILA DWI AZZAHRA',
            'ARUNEE FATINA LUBIS',
            "ASLAM MAHDY NASAB BA'EM",
            'AULIA TRI ANANTA',
            'CALLYSTA RAHADI ALLANZA PUTRI',
            'CHIEO NUGIE ALICHWAN PRAMANA',
            'DANIEL',
            'DZAKI ALVARO',
            'FATIR PERDANA AKBAR',
            'GRACYA ALENKA',
            'HILMIYA AZZA KIRAH',
            'JERRICHO MENEZ TARIGAN',
            'KAISHA IZZARA SOFIA',
            'M. DAFA ARDHANA',
            'MICHELLINE CHANG',
            'MIKAYLA ANASTASIA LO',
            'MUHAMAD AL FATIH BIN FIRDAUS',
            'MUHAMMAD ABID DULFALAH SIDIQ',
            'MUHAMMAD ADITYA',
            'MUHAMMAD ALFANI FEBRIAN',
            'NAYLAQUEEN SIDQIA AIMAN',
            'PUTRA AL FATTAH BAHKRY',
            'PUTRI AISAH HIDAYAH',
            'RAFA DWI MURTI',
            'RAFA MUHAMMAD ZIQRI',
            'RAJENDRA MUHAMMAD NARARYA',
            'RANDIKA DZAKIR KAFADI',
            'SHINTA DHEA SYAHPUTRI',
            'SYAHRIL RAMADHAN',
            'SYAKIRA ZIA PUTRI',
            'TRIYA FATMAWATI',
            'ZAHRA PUTRI MULYANA',
        ];

        foreach ($siswaNames as $name) {
            $username = strtolower(str_replace([' ', "'", '.'], '', $name));
            $users[] = [
                'name'      => $name,
                'email'     => $username . '@siswa.com',
                'password'  => Hash::make('siswa1234'),
                'roles'     => 'siswa',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($users);
    }
}
