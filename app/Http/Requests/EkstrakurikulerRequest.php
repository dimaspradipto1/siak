<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EkstrakurikulerRequest extends FormRequest
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

        $id = $this->route('ekstrakurikuler') ? (is_object($this->route('ekstrakurikuler')) ? $this->route('ekstrakurikuler')->id : $this->route('ekstrakurikuler')) : null;
        return [
            'nama_ekskul' => ['required', 'string', 'max:100', 'unique:ekstrakurikulers,nama_ekskul,' . $id],
            'keterangan'  => ['nullable', 'string'],
            'pembina'     => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'nama_ekskul.required' => 'Nama Ekstrakurikuler wajib diisi.',
            'nama_ekskul.unique'   => 'Nama Ekstrakurikuler ini sudah ada.',
        ];
    }

}
