<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_mapel'          => ['nullable', 'string', 'max:50'],
            'nama_mata_pelajaran' => ['required', 'string', 'max:100'],
            'kkm'                 => ['nullable', 'integer', 'min:0', 'max:100'],
            'tp_optimal'          => ['nullable', 'string'],
            'tp_peningkatan'      => ['nullable', 'string'],
            'kelas_id'            => ['nullable', 'exists:kelas,id'],
            'tahun_ajaran_id'     => ['nullable', 'exists:tahun_ajarans,id'],
            'semester_id'         => ['nullable', 'exists:semesters,id'],
            'guru_id'             => ['nullable', 'exists:gurus,id'],
            'hari_mengajar'       => ['nullable', 'string', 'max:20'],
            'jam_mengajar'        => ['nullable', 'string', 'max:50'],
            'status'              => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_mata_pelajaran.required' => 'Nama Mata Pelajaran wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_mapel'          => 'Kode Mata Pelajaran',
            'nama_mata_pelajaran' => 'Nama Mata Pelajaran',
            'kkm'                 => 'KKM',
            'kelas_id'            => 'Kelas',
            'tahun_ajaran_id'     => 'Tahun Ajaran',
            'semester_id'         => 'Semester',
            'guru_id'             => 'Nama Guru',
            'hari_mengajar'       => 'Hari Mengajar',
            'jam_mengajar'        => 'Jam Mengajar',
            'status'              => 'Status',
        ];
    }
}
