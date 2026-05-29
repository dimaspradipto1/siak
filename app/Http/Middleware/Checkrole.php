<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::user()->roles == 'admin' ||
            Auth::user()->roles == 'guru' ||
            Auth::user()->roles == 'wali kelas' ||
            Auth::user()->roles == 'kepala sekolah' ||
            Auth::user()->roles == 'siswa' ||
            Auth::user()->roles == 'orang tua'
        ) {
            return $next($request);
        }
        return $next($request);
    }
}
