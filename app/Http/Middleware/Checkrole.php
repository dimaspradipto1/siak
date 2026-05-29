<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Daftar role yang diizinkan mengakses sistem.
     */
    protected array $allowedRoles = [
        'admin',
        'guru',
        'wali kelas',
        'kepala sekolah',
        'siswa',
        'orang tua',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        if (!in_array(Auth::user()->roles, $this->allowedRoles)) {
            abort(403, 'Akses ditolak. Role Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
