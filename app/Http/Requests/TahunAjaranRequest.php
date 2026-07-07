<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TahunAjaranRequest extends FormRequest
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
            'tahun_mulai'   => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099'],
            'tahun_selesai' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2099'],
            'status'        => ['required', 'in:Aktif,Tidak Aktif'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'tahun_mulai.required'   => 'Tahun mulai wajib diisi.',
            'tahun_mulai.integer'    => 'Tahun mulai harus berupa angka.',
            'tahun_mulai.digits'     => 'Tahun mulai harus 4 digit.',
            'tahun_mulai.min'        => 'Tahun mulai minimal tahun 2000.',
            'tahun_mulai.max'        => 'Tahun mulai maksimal tahun 2099.',
            'tahun_selesai.required' => 'Tahun selesai wajib diisi.',
            'tahun_selesai.integer'  => 'Tahun selesai harus berupa angka.',
            'tahun_selesai.digits'   => 'Tahun selesai harus 4 digit.',
            'tahun_selesai.min'      => 'Tahun selesai minimal tahun 2000.',
            'tahun_selesai.max'      => 'Tahun selesai maksimal tahun 2099.',
            'status.required'        => 'Status wajib dipilih.',
            'status.in'             => 'Status harus Aktif atau Tidak Aktif.',
        ];
    }

}
