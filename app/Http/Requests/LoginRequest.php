<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Semua pengguna boleh mengakses form login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form login.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
            'remember' => ['nullable', 'boolean'],
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
            'email.required'    => 'Email wajib diisi.',
            'email.string'      => 'Email harus berupa teks.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa teks.',
            'password.min'      => 'Password minimal :min karakter.',
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
            'email'    => 'Email',
            'password' => 'Password',
        ];
    }
}
