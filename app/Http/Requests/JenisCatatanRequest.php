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

        $id = null;
        $routeModel = $this->route('jeniscatatan');
        if ($routeModel) {
            $id = is_object($routeModel) ? $routeModel->id : $routeModel;
        }

        return [
            'kode'               => ['required', 'integer', \Illuminate\Validation\Rule::unique('jenis_catatans', 'kode')->ignore($id)],
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
