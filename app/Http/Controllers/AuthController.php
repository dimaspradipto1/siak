<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->roles === 'siswa') {
                return redirect()->route('siswa.profile');
            }
            return redirect()->route('dashboard');
        }

        return view('layouts.auth.login');
    }

    /**
     * Proses login pengguna.
     * Validasi ditangani otomatis oleh LoginRequest.
     */
    public function loginProses(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            $nama = Auth::user()->name;
            $role = ucwords(Auth::user()->roles);

            toast('Selamat datang, ' . $nama . '! Anda login sebagai ' . $role . '.', 'success');

            if (Auth::user()->roles === 'siswa') {
                return redirect()->route('siswa.profile');
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withInput($request->only('login'))
            ->withErrors([
                'login' => 'Email/Username atau password yang Anda masukkan salah.',
            ]);
    }

    /**
     * Beralih tampilan menu antara Guru dan Wali Kelas untuk guru
     * yang juga sedang ditugaskan sebagai wali kelas.
     */
    public function switchRole(Request $request, string $role)
    {
        $user = Auth::user();
        $target = $role === 'wali-kelas' ? 'wali kelas' : 'guru';

        if ($user->roles !== 'guru' || !$user->isWaliKelasAktif()) {
            abort(403, 'Anda tidak memiliki akses untuk beralih peran.');
        }

        $request->session()->put('active_role', $target);

        toast('Anda sekarang login sebagai ' . ucwords($target) . '.', 'success');

        return redirect()->route('dashboard');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('Anda berhasil keluar dari sistem. Sampai jumpa!', 'info');

        return redirect()->route('login');
    }
}
