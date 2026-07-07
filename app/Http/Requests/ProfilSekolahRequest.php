<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilSekolahRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengakses form ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form profil sekolah.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nama_sekolah'        => ['required', 'string', 'max:255'],
            'nis_nss_nds'         => ['nullable', 'string', 'max:255'],
            'nama_kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'nip_kepala_sekolah'  => ['nullable', 'string', 'max:255'],
            'alamat_sekolah'      => ['nullable', 'string'],
            'kelurahan_desa'      => ['nullable', 'string', 'max:255'],
            'kecamatan'           => ['nullable', 'string', 'max:255'],
            'kabupaten_kota'      => ['nullable', 'string', 'max:255'],
            'provinsi'            => ['nullable', 'string', 'max:255'],
            'kode_pos'            => ['nullable', 'string', 'max:10'],
            'tanggal_berdiri'     => ['nullable', 'date'],
            'tahun_ajaran_id'     => ['nullable', 'exists:tahun_ajarans,id'],
            'no_telephone'        => ['nullable', 'string', 'max:20'],
            'email'               => ['nullable', 'email', 'max:255'],
            'status'              => ['nullable', 'string', 'max:50'],
            'logo_sekolah'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'deskripsi'           => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_sekolah.required' => 'Nama Sekolah wajib diisi.',
            'nama_sekolah.string'   => 'Nama Sekolah harus berupa teks.',
            'nama_sekolah.max'      => 'Nama Sekolah maksimal 255 karakter.',
            'email.email'           => 'Format email tidak valid.',
            'logo_sekolah.image'    => 'Logo Sekolah harus berupa file gambar.',
            'logo_sekolah.mimes'    => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'logo_sekolah.max'      => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    /**
     * Nama label field untuk pesan error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_sekolah'        => 'Nama Sekolah',
            'nis_nss_nds'         => 'NIS/NSS/NDS',
            'nama_kepala_sekolah' => 'Nama Kepala Sekolah',
            'nip_kepala_sekolah'  => 'NIP Kepala Sekolah',
            'alamat_sekolah'      => 'Alamat Sekolah',
            'kelurahan_desa'      => 'Kelurahan/Desa',
            'kecamatan'           => 'Kecamatan',
            'kabupaten_kota'      => 'Kabupaten/Kota',
            'provinsi'            => 'Provinsi',
            'kode_pos'            => 'Kode Pos',
            'tanggal_berdiri'     => 'Tanggal Berdiri',
            'tahun_ajaran_id'     => 'Tahun Ajaran',
            'no_telephone'        => 'No Telephone',
            'email'               => 'Email',
            'status'              => 'Status',
            'logo_sekolah'        => 'Logo Sekolah',
            'deskripsi'           => 'Deskripsi',
        ];
    }
}
