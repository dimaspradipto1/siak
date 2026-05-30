<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use App\Http\Requests\StorePengumumanRequest;
use App\Http\Requests\UpdatePengumumanRequest;
use App\DataTables\PengumumanDataTable;

class PengumumanController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;
    public function index(PengumumanDataTable $dataTable)
    {
        return $dataTable->render('pages.pengumuman.index');
    }

    public function create()
    {
        $users = User::all();
        return view('pages.pengumuman.create', compact('users'));
    }

    public function store(StorePengumumanRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id(); // assign to current user
        $pengumuman = Pengumuman::create($validated);

        alert()->success(
            'Berhasil!',
            'Pengumuman berhasil dipublikasikan.'
        );

        return redirect()->route('pengumuman.index');
    }

    public function show(Pengumuman $pengumuman)
    {
        return redirect()->route('pengumuman.edit', $pengumuman);
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('pages.pengumuman.edit', compact('pengumuman'));
    }

    public function update(UpdatePengumumanRequest $request, Pengumuman $pengumuman)
    {
        $validated = $request->validated();
        $pengumuman->update($validated);

        alert()->success(
            'Diperbarui!',
            'Pengumuman berhasil diperbarui.'
        );

        return redirect()->route('pengumuman.index');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        alert()->success(
            'Dihapus!',
            'Pengumuman berhasil dihapus.'
        );

        return redirect()->route('pengumuman.index');
    }
}
