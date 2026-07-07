<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatatanSiswaRequest extends FormRequest
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

        return [
            'jenis_catatan_id' => ['required', 'exists:jenis_catatans,id'],
            'siswa_id'        => ['required', 'exists:siswas,id'],
            'guru_id'         => ['required', 'exists:gurus,id'],
            'semester_id'     => ['required', 'exists:semesters,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
            'tanggal'         => ['required', 'date'],
            'isi_catatan'     => ['required', 'string'],
            'tindak_lanjut'   => ['nullable', 'string'],
            'status'          => ['required', 'string', 'max:50'],
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
