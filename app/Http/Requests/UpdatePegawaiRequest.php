<?php

namespace App\Http\Requests;

use App\Models\Pegawai;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
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
        $pegawai = $this->route('pegawai');
        $pegawaiId = $pegawai instanceof Pegawai ? $pegawai->id : $pegawai;

        return [
            'nip'           => ['required', 'string', Rule::unique('pegawais', 'nip')->ignore($pegawaiId), 'max:50'],
            'nama_pegawai'  => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'  => ['required', 'string', 'max:100'],
            'tgl_lahir'     => ['required', 'date'],
            'jabatan'       => ['required', 'string', 'max:100'],
            'agama'         => ['required', 'string', 'max:50'],
            'nomor_wa'      => ['nullable', 'string', 'max:20'],
            'alamat'        => ['nullable', 'string'],
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
            'nip.required'           => 'NIP wajib diisi.',
            'nip.string'             => 'NIP harus berupa teks.',
            'nip.unique'             => 'NIP sudah digunakan oleh pegawai lain.',
            'nip.max'                => 'NIP maksimal :max karakter.',
            'nama_pegawai.required'  => 'Nama pegawai wajib diisi.',
            'nama_pegawai.string'    => 'Nama pegawai harus berupa teks.',
            'nama_pegawai.max'       => 'Nama pegawai maksimal :max karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string'    => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max'       => 'Tempat lahir maksimal :max karakter.',
            'tgl_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date'         => 'Format tanggal lahir tidak valid.',
            'jabatan.required'       => 'Jabatan wajib diisi.',
            'jabatan.string'         => 'Jabatan harus berupa teks.',
            'jabatan.max'            => 'Jabatan maksimal :max karakter.',
            'agama.required'         => 'Agama wajib diisi.',
            'agama.string'           => 'Agama harus berupa teks.',
            'agama.max'              => 'Agama maksimal :max karakter.',
            'nomor_wa.string'        => 'Nomor WA harus berupa teks.',
            'nomor_wa.max'           => 'Nomor WA maksimal :max karakter.',
            'alamat.string'          => 'Alamat harus berupa teks.',
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
            'nip'           => 'NIP',
            'nama_pegawai'  => 'Nama Pegawai',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir'  => 'Tempat Lahir',
            'tgl_lahir'     => 'Tanggal Lahir',
            'jabatan'       => 'Jabatan',
            'agama'         => 'Agama',
            'nomor_wa'      => 'Nomor WhatsApp',
            'alamat'        => 'Alamat',
        ];
    }
}
