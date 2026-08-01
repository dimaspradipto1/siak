<?php

namespace Database\Seeders;

use App\Models\ProfilSekolah;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class ProfilSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::where('status', 'Aktif')->first();

        ProfilSekolah::create([
            'nama_sekolah'         => 'SD Negeri 007 Sekupang',
            'nis_nss_nds'          => '100070',
            'nama_kepala_sekolah'  => 'Yusal, S.Pd.',
            'nip_kepala_sekolah'   => '197403122005011002',
            'alamat_sekolah'       => 'Jl. Tambelan Blok K, Tiban Indah',
            'kelurahan_desa'       => 'Tiban Indah',
            'kecamatan'            => 'Sekupang',
            'kabupaten_kota'       => 'Kota Batam',
            'provinsi'             => 'Kepulauan Riau',
            'kode_pos'             => '29424',
            'tanggal_berdiri'      => '1995-08-01',
            'tahun_ajaran_id'      => $tahunAjaran ? $tahunAjaran->id : null,
            'no_telephone'         => '0778-123456',
            'email'                => 'sdn007sekupang@gmail.com',
            'status'               => 'Negeri',
            'logo_sekolah'         => 'assets/img/logo.png',
            'deskripsi'            => 'Sekolah Dasar Negeri 007 Sekupang adalah sekolah dasar negeri yang berlokasi di Tiban Indah, Sekupang, Batam, Kepulauan Riau.',
        ]);
    }
}
