<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => ['required', 'string', 'max:50', 'unique:kelas,nama_kelas,' . $this->route('kela')?->id],
            'tingkat'    => ['required', 'string', 'max:50'],
            'ruangan'    => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama Kelas sudah ada.',
            'tingkat.required'    => 'Tingkat wajib diisi.',
            'ruangan.required'    => 'Ruangan wajib diisi.',
        ];
    }
}
