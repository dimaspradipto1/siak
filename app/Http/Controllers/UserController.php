<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna (DataTables).
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('pages.user.index', compact('users'));
    }

    /**
     * Tampilkan form tambah pengguna.
     */
    public function create()
    {
        $roles = User::ROLES;

        return view('pages.user.create', compact('roles'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'roles'     => $validated['roles'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        alert()->success(
            'Berhasil!',
            'Pengguna <strong>' . e($validated['name']) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('user.index');
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        $roles = User::ROLES;

        return view('pages.user.edit', compact('user', 'roles'));
    }

    /**
     * Update data pengguna.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $data = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'roles'     => $validated['roles'],
            'is_active' => $request->boolean('is_active'),
        ];

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        alert()->success(
            'Diperbarui!',
            'Data pengguna <strong>' . e($user->name) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('user.index');
    }

    /**
     * Hapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        $nama = $user->name;
        $user->delete();

        alert()->success('Dihapus!', 'Pengguna <strong>' . e($nama) . '</strong> berhasil dihapus.')->html();

        return redirect()->route('user.index');
    }

    /**
     * show — redirect ke edit.
     */
    public function show(User $user)
    {
        return redirect()->route('user.edit', $user);
    }
}
