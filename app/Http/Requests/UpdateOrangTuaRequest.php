<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrangTuaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_ayah'      => ['nullable', 'string', 'max:100'],
            'nama_ibu'       => ['nullable', 'string', 'max:100'],
            'nomor_wa'       => ['nullable', 'string', 'max:20'],
            'alamat'         => ['nullable', 'string'],
            'pekerjaan_ayah' => ['nullable', 'string', 'max:100'],
            'pekerjaan_ibu'  => ['nullable', 'string', 'max:100'],
        ];
    }
}
