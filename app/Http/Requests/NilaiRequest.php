<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiRequest extends FormRequest
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
            'siswa_id'          => ['required', 'exists:siswas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'semester_id'       => ['required', 'exists:semesters,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajarans,id'],
            'nilai'             => ['required', 'numeric', 'min:0', 'max:100'],
            'predikat'          => ['required', 'string', 'max:10'],
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
