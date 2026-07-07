<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiRequest extends FormRequest
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
            'siswa_id'          => ['required', 'exists:siswas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'semester_id'       => ['required', 'exists:semesters,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajarans,id'],
            
            'lm1_tp1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm1_tp2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm1_tp3' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm1_tp4' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm1'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            'lm2_tp1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm2_tp2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm2_tp3' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm2_tp4' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm2'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            'lm3_tp1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm3_tp2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm3_tp3' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm3_tp4' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm3'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            'lm4_tp1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm4_tp2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm4_tp3' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm4_tp4' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm4'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            'lm5_tp1' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm5_tp2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm5_tp3' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm5_tp4' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lm5'     => ['nullable', 'numeric', 'min:0', 'max:100'],

            'nilai_harian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_mid'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_mid_plus' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_pas'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_pas_plus' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_raport' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'nilai'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'predikat' => ['nullable', 'string', 'max:10'],
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
