<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KehadiranRequest extends FormRequest
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

        return [
            'jenis_kehadiran_id' => ['required', 'exists:jenis_kehadirans,id'],
            'mata_pelajaran_id'  => ['required', 'exists:mata_pelajarans,id'],
            'siswa_id'           => ['required', 'exists:siswas,id'],
            'tanggal'            => ['required', 'date'],
            'keterangan'         => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
return [];
    }

}
