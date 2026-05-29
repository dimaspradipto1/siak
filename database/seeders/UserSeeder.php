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
                'name'      => 'Guru',
                'email'     => 'guru@gmail.com',
                'password'  => Hash::make('guru1234'),
                'roles'     => 'guru',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Wali Kelas',
                'email'     => 'walikelas@gmail.com',
                'password'  => Hash::make('walikelas1234'),
                'roles'     => 'wali kelas',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Kepala Sekolah',
                'email'     => 'kepsek@gmail.com',
                'password'  => Hash::make('kepsek1234'),
                'roles'     => 'kepala sekolah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Siswa',
                'email'     => 'siswa@gmail.com',
                'password'  => Hash::make('siswa1234'),
                'roles'     => 'siswa',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Orang Tua',
                'email'     => 'orangtua@gmail.com',
                'password'  => Hash::make('orangtua1234'),
                'roles'     => 'orang tua',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        User::insert($users);
    }
}
