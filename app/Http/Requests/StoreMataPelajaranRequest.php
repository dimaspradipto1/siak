<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_mata_pelajaran' => ['required', 'string', 'max:100', 'unique:mata_pelajarans,nama_mata_pelajaran'],
            'kkm'                 => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_mata_pelajaran.required' => 'Nama Mata Pelajaran wajib diisi.',
            'nama_mata_pelajaran.unique'   => 'Mata Pelajaran ini sudah ada.',
            'kkm.required'                 => 'KKM wajib diisi.',
            'kkm.min'                      => 'KKM minimal 0.',
            'kkm.max'                      => 'KKM maksimal 100.',
        ];
    }
}
