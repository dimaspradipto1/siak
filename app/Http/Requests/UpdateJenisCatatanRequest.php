<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisCatatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode'               => ['required', 'integer', 'unique:jenis_catatans,kode,' . $this->route('jenis_catatan')?->id],
            'nama_jenis_catatan' => ['required', 'string', 'max:100'],
            'keterangan'         => ['nullable', 'string'],
        ];
    }
}
