<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JabatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_jabatan' => ['nullable', 'string', 'max:50'],
            'nama_jabatan' => ['required', 'string', 'max:255'],
            'keterangan'   => ['nullable', 'string'],
            'status'       => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_jabatan.required' => 'Nama Jabatan wajib diisi.',
            'nama_jabatan.max'      => 'Nama Jabatan maksimal 255 karakter.',
        ];
    }
}
