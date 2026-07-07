<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisCatatanRequest extends FormRequest
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

        $id = $this->route('jenis_catatan') ? (is_object($this->route('jenis_catatan')) ? $this->route('jenis_catatan')->id : $this->route('jenis_catatan')) : null;
        return [
            'kode'               => ['required', 'integer', 'unique:jenis_catatans,kode,' . $id],
            'nama_jenis_catatan' => ['required', 'string', 'max:100'],
            'keterangan'         => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
return [];
    }

}
