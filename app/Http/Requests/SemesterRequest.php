<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
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
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
            'nama_semester'   => ['required', 'string', 'max:50'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'tahun_ajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun Ajaran yang dipilih tidak valid.',
            'nama_semester.required'   => 'Nama Semester wajib diisi.',
            'nama_semester.string'     => 'Nama Semester harus berupa teks.',
            'nama_semester.max'        => 'Nama Semester maksimal :max karakter.',
        ];
    }

}
