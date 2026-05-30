<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateUserAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user accounts for existing Siswa, Pegawai, and OrangTua data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating user accounts...');

        // Siswa
        $siswas = \App\Models\Siswa::query()->whereNull('user_id')->get();
        foreach ($siswas as $siswa) {
            $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($siswa->nisn));
            $user = \App\Models\User::create([
                'name' => $siswa->nama_siswa,
                'username' => $username,
                'email' => $username . '@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'roles' => 'siswa',
                'is_active' => true,
            ]);
            $siswa->update(['user_id' => $user->id]);
            $this->info("Created user for Siswa: {$siswa->nama_siswa}");
        }

        // Pegawai / Guru
        $pegawais = \App\Models\Pegawai::query()->whereNull('user_id')->get();
        foreach ($pegawais as $pegawai) {
            $role = $pegawai->guru ? 'guru' : 'pegawai'; // Simplification
            $rawUsername = $pegawai->nip ?: 'pegawai_' . $pegawai->id;
            $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($rawUsername));
            $user = \App\Models\User::create([
                'name' => $pegawai->nama_pegawai,
                'username' => $username,
                'email' => $username . '@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'roles' => $role,
                'is_active' => true,
            ]);
            $pegawai->update(['user_id' => $user->id]);
            $this->info("Created user for Pegawai: {$pegawai->nama_pegawai}");
        }

        // Orang Tua
        $orangTuas = \App\Models\OrangTua::query()->whereNull('user_id')->get();
        foreach ($orangTuas as $ot) {
            $rawUsername = $ot->nomor_wa ?: 'ortu_' . $ot->id;
            $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($rawUsername));
            $user = \App\Models\User::create([
                'name' => 'Ortu dari ' . ($ot->siswa->first()->nama_siswa ?? 'Siswa'),
                'username' => $username,
                'email' => $username . '@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'roles' => 'orang tua',
                'is_active' => true,
            ]);
            $ot->update(['user_id' => $user->id]);
            $this->info("Created user for Orang Tua: {$user->name}");
        }

        $this->info('Done!');
    }
}
