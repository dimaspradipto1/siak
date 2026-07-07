<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataPelajaranRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengakses form ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form mata pelajaran.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'kode_mapel'          => ['required', 'string', 'max:50'],
            'nama_mata_pelajaran' => ['required', 'string', 'max:100'],
            'kkm'                 => ['required', 'integer', 'min:0', 'max:100'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'     => ['required', 'exists:tahun_ajarans,id'],
            'semester_id'         => ['required', 'exists:semesters,id'],
            'guru_id'             => ['required', 'exists:gurus,id'],
            'hari_mengajar'       => ['required', 'string', 'max:20'],
            'jam_mengajar'        => ['required', 'string', 'max:50'],
            'tp_optimal'          => ['nullable', 'string'],
            'tp_peningkatan'      => ['nullable', 'string'],
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
            'kode_mapel.required'          => 'Kode Mapel wajib diisi.',
            'nama_mata_pelajaran.required' => 'Nama Mata Pelajaran wajib diisi.',
            'kkm.required'                 => 'KKM wajib diisi.',
            'kkm.min'                      => 'KKM minimal 0.',
            'kkm.max'                      => 'KKM maksimal 100.',
            'kelas_id.required'            => 'Kelas wajib dipilih.',
            'kelas_id.exists'              => 'Kelas tidak valid.',
            'tahun_ajaran_id.required'     => 'Tahun Ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'       => 'Tahun Ajaran tidak valid.',
            'semester_id.required'         => 'Semester wajib dipilih.',
            'semester_id.exists'           => 'Semester tidak valid.',
            'guru_id.required'             => 'Guru Pengajar wajib dipilih.',
            'guru_id.exists'               => 'Guru tidak valid.',
            'hari_mengajar.required'       => 'Hari mengajar wajib diisi.',
            'jam_mengajar.required'        => 'Jam mengajar wajib diisi.',
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
            'kode_mapel'          => 'Kode Mapel',
            'nama_mata_pelajaran' => 'Nama Mapel',
            'kkm'                 => 'KKM',
            'kelas_id'            => 'Kelas',
            'tahun_ajaran_id'     => 'Tahun Ajaran',
            'semester_id'         => 'Semester',
            'guru_id'             => 'Guru Pengajar',
            'hari_mengajar'       => 'Hari Mengajar',
            'jam_mengajar'        => 'Jam Mengajar',
            'tp_optimal'          => 'TP Optimal',
            'tp_peningkatan'      => 'TP Peningkatan',
        ];
    }
}
