<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembagianKelasRequest extends FormRequest
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
            'siswa_id'        => ['required', 'exists:siswas,id'],
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
            'siswa_id.required'        => 'Siswa wajib dipilih.',
            'siswa_id.exists'          => 'Siswa tidak valid.',
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'kelas_id.exists'          => 'Kelas tidak valid.',
            'tahun_ajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun Ajaran tidak valid.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $siswaId = $this->input('siswa_id');
            $tahunAjaranId = $this->input('tahun_ajaran_id');
            
            $pembagianKelasModel = $this->route('pembagiankela') ?? $this->route('pembagiankelas');
            $currentId = is_object($pembagianKelasModel) ? $pembagianKelasModel->id : $pembagianKelasModel;

            if ($siswaId && $tahunAjaranId) {
                $query = \App\Models\PembagianKelas::where('siswa_id', $siswaId)
                    ->where('tahun_ajaran_id', $tahunAjaranId);
                    
                if ($currentId) {
                    $query->where('id', '!=', $currentId);
                }

                if ($query->exists()) {
                    $validator->errors()->add('siswa_id', 'Siswa ini sudah memiliki pembagian kelas untuk tahun ajaran tersebut.');
                }
            }
        });
    }
}
