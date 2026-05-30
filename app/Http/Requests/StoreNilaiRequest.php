<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
}
