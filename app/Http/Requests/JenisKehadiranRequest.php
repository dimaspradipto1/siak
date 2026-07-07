<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisKehadiranRequest extends FormRequest
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

        $id = $this->route('jeniskehadiran') ? (is_object($this->route('jeniskehadiran')) ? $this->route('jeniskehadiran')->id : $this->route('jeniskehadiran')) : null;
        return [
            'kode_kehadiran' => ['required', 'string', 'max:10', 'unique:jenis_kehadirans,kode_kehadiran,' . $id],
            'nama_kehadiran' => ['required', 'string', 'max:50'],
            'keterangan'     => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'kode_kehadiran.required' => 'Kode Kehadiran wajib diisi.',
            'kode_kehadiran.unique'   => 'Kode Kehadiran ini sudah digunakan.',
            'nama_kehadiran.required' => 'Nama Kehadiran wajib diisi.',
        ];
    }

}
