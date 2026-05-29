<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk request ini.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'pegawai_id'          => ['required', 'exists:pegawais,id', 'unique:gurus,pegawai_id'],
            'nip_guru'            => ['required', 'string', 'unique:gurus,nip_guru', 'max:50'],
            'golongan'            => ['required', 'string', 'max:50'],
            'pendidikan_terakhir' => ['required', 'string', 'max:100'],
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
            'pegawai_id.required'          => 'Pegawai wajib dipilih.',
            'pegawai_id.exists'            => 'Pegawai yang dipilih tidak valid.',
            'pegawai_id.unique'            => 'Pegawai yang dipilih sudah terdaftar sebagai Guru.',
            'nip_guru.required'            => 'NIP Guru wajib diisi.',
            'nip_guru.string'              => 'NIP Guru harus berupa teks.',
            'nip_guru.unique'              => 'NIP Guru sudah terdaftar.',
            'nip_guru.max'                 => 'NIP Guru maksimal :max karakter.',
            'golongan.required'            => 'Golongan wajib diisi.',
            'golongan.string'              => 'Golongan harus berupa teks.',
            'golongan.max'                 => 'Golongan maksimal :max karakter.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.string'   => 'Pendidikan terakhir harus berupa teks.',
            'pendidikan_terakhir.max'      => 'Pendidikan terakhir maksimal :max karakter.',
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
            'pegawai_id'          => 'Pegawai',
            'nip_guru'            => 'NIP Guru',
            'golongan'            => 'Golongan',
            'pendidikan_terakhir' => 'Pendidikan Terakhir',
        ];
    }
}
