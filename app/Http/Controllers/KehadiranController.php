<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\JenisKehadiran;
use App\Http\Requests\StoreKehadiranRequest;
use App\Http\Requests\UpdateKehadiranRequest;
use App\DataTables\KehadiranDataTable;

class KehadiranController extends Controller
{
    public function index(KehadiranDataTable $dataTable)
    {
        return $dataTable->render('pages.kehadiran.index');
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->get();
        $mapels = MataPelajaran::all();
        $jenisKehadirans = JenisKehadiran::all();
        return view('pages.kehadiran.create', compact('siswas', 'mapels', 'jenisKehadirans'));
    }

    public function store(StoreKehadiranRequest $request)
    {
        $validated = $request->validated();
        Kehadiran::create($validated);

        alert()->success(
            'Berhasil!',
            'Data kehadiran berhasil ditambahkan.'
        );

        return redirect()->route('kehadiran.index');
    }

    public function show(Kehadiran $kehadiran)
    {
        return redirect()->route('kehadiran.edit', $kehadiran);
    }

    public function edit(Kehadiran $kehadiran)
    {
        $siswas = Siswa::with('kelas')->get();
        $mapels = MataPelajaran::all();
        $jenisKehadirans = JenisKehadiran::all();
        return view('pages.kehadiran.edit', compact('kehadiran', 'siswas', 'mapels', 'jenisKehadirans'));
    }

    public function update(UpdateKehadiranRequest $request, Kehadiran $kehadiran)
    {
        $validated = $request->validated();
        $kehadiran->update($validated);

        alert()->success(
            'Diperbarui!',
            'Data kehadiran berhasil diperbarui.'
        );

        return redirect()->route('kehadiran.index');
    }

    public function destroy(Kehadiran $kehadiran)
    {
        $kehadiran->delete();

        alert()->success(
            'Dihapus!',
            'Data kehadiran berhasil dihapus.'
        );

        return redirect()->route('kehadiran.index');
    }
}
