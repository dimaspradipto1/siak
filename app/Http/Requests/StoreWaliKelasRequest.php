<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWaliKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guru_id'         => ['required', 'exists:gurus,id'],
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
        ];
    }

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

            if ($guruId && $kelasId && $tahunAjaranId) {
                // Cek apakah guru sudah menjadi wali kelas di tahun ajaran yang sama
                $guruExists = \App\Models\WaliKelas::where('guru_id', $guruId)
                    ->where('tahun_ajaran_id', $tahunAjaranId)
                    ->exists();

                if ($guruExists) {
                    $validator->errors()->add('guru_id', 'Guru ini sudah menjadi wali kelas di tahun ajaran tersebut.');
                }

                // Cek apakah kelas sudah memiliki wali kelas di tahun ajaran yang sama
                $kelasExists = \App\Models\WaliKelas::where('kelas_id', $kelasId)
                    ->where('tahun_ajaran_id', $tahunAjaranId)
                    ->exists();

                if ($kelasExists) {
                    $validator->errors()->add('kelas_id', 'Kelas ini sudah memiliki wali kelas di tahun ajaran tersebut.');
                }
            }
        });
    }
}
