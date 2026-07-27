<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengakses form ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form.
     */
    public function rules(): array
    {
        $id = $this->route('siswa') ? (is_object($this->route('siswa')) ? $this->route('siswa')->id : $this->route('siswa')) : null;
        return [
            'nisn'                        => ['required', 'string', 'max:50', 'unique:siswas,nisn,' . $id],
            'nama_siswa'                  => ['required', 'string', 'max:100'],
            'jenis_kelamin'               => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'                => ['required', 'string', 'max:100'],
            'tgl_lahir'                   => ['required', 'date'],
            'agama'                       => ['required', 'string', 'max:50'],
            'nomor_wa'                    => ['nullable', 'string', 'max:20'],
            'alamat'                      => ['nullable', 'string'],
            'tgl_masuk'                   => ['nullable', 'date'],
            'status'                      => ['nullable', 'string', 'max:50'],
            'kelas_id'                    => ['nullable', 'exists:kelas,id'],
            'orang_tua_id'                => ['nullable', 'exists:orang_tuas,id'],
            'ekstrakurikuler_id'          => ['nullable', 'exists:ekstrakurikulers,id'],

            // Additional fields matching UX form
            'email_siswa'                 => ['nullable', 'email'],
            'password_siswa'              => ['nullable', 'string', 'min:6', 'confirmed'],
            'nama_ayah'                   => ['nullable', 'string', 'max:255'],
            'pekerjaan_ayah'              => ['nullable', 'string', 'max:255'],
            'nomor_wa_ayah'               => ['nullable', 'string', 'max:20'],
            'nama_ibu'                    => ['nullable', 'string', 'max:255'],
            'pekerjaan_ibu'               => ['nullable', 'string', 'max:255'],
            'nomor_wa_ibu'                => ['nullable', 'string', 'max:20'],
            'alamat_ortu'                 => ['nullable', 'string'],
            'email_ortu'                  => ['nullable', 'email'],
            'password_ortu'               => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'nisn.required'              => 'NISN wajib diisi.',
            'nisn.unique'                => 'NISN sudah terdaftar.',
            'nama_siswa.required'        => 'Nama Lengkap wajib diisi.',
            'jenis_kelamin.required'     => 'Jenis Kelamin wajib dipilih.',
            'tempat_lahir.required'       => 'Tempat Lahir wajib diisi.',
            'tgl_lahir.required'          => 'Tanggal Lahir wajib diisi.',
            'agama.required'              => 'Agama wajib dipilih.',
            'password_siswa.confirmed'   => 'Konfirmasi Password Siswa tidak cocok.',
            'password_ortu.confirmed'    => 'Konfirmasi Password Orang Tua tidak cocok.',
        ];
    }
}
