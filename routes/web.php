<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIAK SD Negeri 007 Sekupang
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Auth Routes ────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'loginProses'])->name('loginProses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Dashboard Routes (dilindungi middleware auth + checkrole) ──────────
Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
