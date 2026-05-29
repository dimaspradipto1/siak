<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard sesuai role pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        return view('layouts.dashboard.index', compact('user'));
    }
}
