<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkstrakurikulerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_ekskul' => ['required', 'string', 'max:100', 'unique:ekstrakurikulers,nama_ekskul'],
            'keterangan'  => ['nullable', 'string'],
            'pembina'     => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_ekskul.required' => 'Nama Ekstrakurikuler wajib diisi.',
            'nama_ekskul.unique'   => 'Nama Ekstrakurikuler ini sudah ada.',
        ];
    }
}
