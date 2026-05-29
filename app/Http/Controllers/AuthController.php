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
            return redirect()->route('dashboard');
        }

        return view('layouts.auth.login');
    }

    /**
     * Proses login pengguna.
     * Validasi ditangani otomatis oleh LoginRequest.
     */
    public function loginProses(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $nama = Auth::user()->name;
            $role = ucwords(Auth::user()->roles);

            toast('Selamat datang, ' . $nama . '! Anda login sebagai ' . $role . '.', 'success');

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
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
