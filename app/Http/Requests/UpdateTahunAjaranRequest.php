<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTahunAjaranRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk request ini.
     *
     * @return array<string, mixed>
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
     * Pesan error kustom dalam Bahasa Indonesia.
     *
     * @return array<string, string>
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
            'status.in'              => 'Status harus Aktif atau Tidak Aktif.',
        ];
    }

    /**
     * Nama label field untuk pesan error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tahun_mulai'   => 'Tahun Mulai',
            'tahun_selesai' => 'Tahun Selesai',
            'status'        => 'Status',
        ];
    }

    /**
     * Validasi tambahan setelah validasi dasar berhasil.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $mulai   = $this->input('tahun_mulai');
            $selesai = $this->input('tahun_selesai');

            if ($mulai && $selesai && (int) $selesai !== (int) $mulai + 1) {
                $validator->errors()->add('tahun_selesai', 'Tahun selesai harus tepat 1 tahun setelah tahun mulai (contoh: 2024 → 2025).');
            }
        });
    }
}
