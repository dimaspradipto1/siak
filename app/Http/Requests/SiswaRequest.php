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
            'nisn'               => ['required', 'string', 'max:50', 'unique:siswas,nisn,' . $id],
            'nama_siswa'         => ['required', 'string', 'max:100'],
            'jenis_kelamin'      => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'       => ['required', 'string', 'max:100'],
            'tgl_lahir'          => ['required', 'date'],
            'agama'              => ['required', 'string', 'max:50'],
            'nomor_wa'           => ['nullable', 'string', 'max:20'],
            'alamat'             => ['nullable', 'string'],
            'tgl_masuk'          => ['nullable', 'date'],
            'status'             => ['nullable', 'string', 'max:50'],
            'kelas_id'           => ['required', 'exists:kelas,id'],
            'orang_tua_id'       => ['required', 'exists:orang_tuas,id'],
            'ekstrakurikuler_id' => ['nullable', 'exists:ekstrakurikulers,id'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'nisn.required'         => 'NISN wajib diisi.',
            'nisn.unique'           => 'NISN sudah terdaftar.',
            'nama_siswa.required'   => 'Nama Siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
            'tempat_lahir.required'  => 'Tempat Lahir wajib diisi.',
            'tgl_lahir.required'     => 'Tanggal Lahir wajib diisi.',
            'agama.required'         => 'Agama wajib diisi.',
            'kelas_id.required'       => 'Kelas wajib dipilih.',
            'orang_tua_id.required'   => 'Orang Tua (Wali) wajib dipilih.',
        ];
    }

}
