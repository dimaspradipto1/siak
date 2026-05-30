<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisKehadiranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_kehadiran' => ['required', 'string', 'max:10', 'unique:jenis_kehadirans,kode_kehadiran,' . $this->route('jeniskehadiran')?->id],
            'nama_kehadiran' => ['required', 'string', 'max:50'],
            'keterangan'     => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_kehadiran.required' => 'Kode Kehadiran wajib diisi.',
            'kode_kehadiran.unique'   => 'Kode Kehadiran ini sudah digunakan.',
            'nama_kehadiran.required' => 'Nama Kehadiran wajib diisi.',
        ];
    }
}
