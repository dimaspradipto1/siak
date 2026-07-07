<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengakses form ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form kelas.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->route('kela') ? $this->route('kela')->id : null;
        return [
            'nama_kelas' => ['required', 'string', 'max:50', 'unique:kelas,nama_kelas,' . $id],
            'tingkat'    => ['required', 'string', 'max:50'],
            'ruangan'    => ['required', 'string', 'max:50'],
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
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama Kelas sudah ada.',
            'tingkat.required'    => 'Tingkat wajib diisi.',
            'ruangan.required'    => 'Ruangan wajib diisi.',
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
            'nama_kelas' => 'Nama Kelas',
            'tingkat'    => 'Tingkat',
            'ruangan'    => 'Ruangan',
        ];
    }
}
