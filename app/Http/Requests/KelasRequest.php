<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('kela') ? (is_object($this->route('kela')) ? $this->route('kela')->id : $this->route('kela')) : null;
        return [
            'kode_kelas' => ['nullable', 'string', 'max:50'],
            'nama_kelas' => ['required', 'string', 'max:50', 'unique:kelas,nama_kelas,' . $id],
            'tingkat'    => ['required', 'string', 'max:50'],
            'ruangan'    => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.unique'   => 'Nama Kelas sudah ada.',
            'tingkat.required'    => 'Tingkat wajib dipilih.',
            'ruangan.required'    => 'Ruangan wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_kelas' => 'Kode Kelas',
            'nama_kelas' => 'Nama Kelas',
            'tingkat'    => 'Tingkat',
            'ruangan'    => 'Ruangan',
        ];
    }
}
