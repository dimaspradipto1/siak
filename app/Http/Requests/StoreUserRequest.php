<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
            'roles'     => ['required', Rule::in(User::ROLES)],
            'is_active' => ['nullable', 'boolean'],
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
            'name.required'      => 'Nama wajib diisi.',
            'name.string'        => 'Nama harus berupa teks.',
            'name.max'           => 'Nama maksimal :max karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required'     => 'Role wajib dipilih.',
            'roles.in'           => 'Role yang dipilih tidak valid.',
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
            'name'      => 'Nama',
            'email'     => 'Email',
            'password'  => 'Password',
            'roles'     => 'Role',
            'is_active' => 'Status Aktif',
        ];
    }
}
