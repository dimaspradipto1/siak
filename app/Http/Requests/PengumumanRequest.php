<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengumumanRequest extends FormRequest
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
            'judul'             => ['required', 'string', 'max:255'],
            'keterangan'        => ['required', 'string'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajarans,id'],
            'semester_id'       => ['required', 'exists:semesters,id'],
            'kelas_id'          => ['nullable', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajarans,id'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'judul.required'           => 'Judul Pengumuman wajib diisi.',
            'judul.max'                => 'Judul Pengumuman maksimal 255 karakter.',
            'keterangan.required'      => 'Isi Pengumuman wajib diisi.',
            'tahun_ajaran_id.required' => 'Tahun Ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'   => 'Tahun Ajaran tidak valid.',
            'semester_id.required'     => 'Semester wajib dipilih.',
            'semester_id.exists'       => 'Semester tidak valid.',
            'kelas_id.exists'          => 'Kelas tidak valid.',
            'mata_pelajaran_id.exists' => 'Mata Pelajaran tidak valid.',
        ];
    }

    /**
     * Label untuk field validation.
     */
    public function attributes(): array
    {
        return [
            'judul'             => 'Judul Pengumuman',
            'keterangan'        => 'Isi Pengumuman',
            'tahun_ajaran_id'   => 'Tahun Ajaran',
            'semester_id'       => 'Semester',
            'kelas_id'          => 'Kelas',
            'mata_pelajaran_id' => 'Mata Pelajaran',
        ];
    }

}
