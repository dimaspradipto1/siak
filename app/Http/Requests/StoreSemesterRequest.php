<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemesterRequest extends FormRequest
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
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajarans,id'],
            'nama_semester'   => ['required', 'string', 'max:50'],
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
            'tahun_ajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun Ajaran yang dipilih tidak valid.',
            'nama_semester.required'   => 'Nama Semester wajib diisi.',
            'nama_semester.string'     => 'Nama Semester harus berupa teks.',
            'nama_semester.max'        => 'Nama Semester maksimal :max karakter.',
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
            'tahun_ajaran_id' => 'Tahun Ajaran',
            'nama_semester'   => 'Nama Semester',
        ];
    }

    /**
     * Validasi tambahan: cegah duplikasi semester dalam satu tahun ajaran.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tahunAjaranId = $this->input('tahun_ajaran_id');
            $namaSemester  = $this->input('nama_semester');

            if ($tahunAjaranId && $namaSemester) {
                $exists = \App\Models\Semester::where('tahun_ajaran_id', $tahunAjaranId)
                    ->where('nama_semester', $namaSemester)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('nama_semester', 'Semester ini sudah terdaftar pada Tahun Ajaran yang dipilih.');
                }
            }
        });
    }
}
