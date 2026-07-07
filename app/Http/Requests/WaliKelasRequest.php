<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaliKelasRequest extends FormRequest
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
            'guru_id'         => ['required', 'exists:gurus,id'],
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {

        return [
            'guru_id.required'         => 'Guru wajib dipilih.',
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'tahun_ajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $guruId = $this->input('guru_id');
            $kelasId = $this->input('kelas_id');
            $tahunAjaranId = $this->input('tahun_ajaran_id');
            
            $waliKelas = $this->route('wali_kela') ?? $this->route('wali_kelas') ?? $this->route('walikela');
            $waliKelasId = is_object($waliKelas) ? $waliKelas->id : $waliKelas;

            if ($guruId && $kelasId && $tahunAjaranId) {
                // Cek apakah guru sudah menjadi wali kelas di tahun ajaran yang sama
                $guruQuery = \App\Models\WaliKelas::where('guru_id', $guruId)
                    ->where('tahun_ajaran_id', $tahunAjaranId);

                if ($waliKelasId) {
                    $guruQuery->where('id', '!=', $waliKelasId);
                }
                
                if ($guruQuery->exists()) {
                    $validator->errors()->add('guru_id', 'Guru ini sudah menjadi wali kelas di tahun ajaran tersebut.');
                }

                // Cek apakah kelas sudah memiliki wali kelas di tahun ajaran yang sama
                $kelasQuery = \App\Models\WaliKelas::where('kelas_id', $kelasId)
                    ->where('tahun_ajaran_id', $tahunAjaranId);
                    
                if ($waliKelasId) {
                    $kelasQuery->where('id', '!=', $waliKelasId);
                }

                if ($kelasQuery->exists()) {
                    $validator->errors()->add('kelas_id', 'Kelas ini sudah memiliki wali kelas di tahun ajaran tersebut.');
                }
            }
        });
    }
}
