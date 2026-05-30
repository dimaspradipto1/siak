<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\DataTables\MataPelajaranDataTable;

class MataPelajaranController extends Controller
{
    public function index(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('pages.mata-pelajaran.index');
    }

    public function create()
    {
        return view('pages.mata-pelajaran.create');
    }

    public function store(StoreMataPelajaranRequest $request)
    {
        $validated = $request->validated();
        $mapel = MataPelajaran::create($validated);

        alert()->success(
            'Berhasil!',
            'Mata Pelajaran <strong>' . e($mapel->nama_mata_pelajaran) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }

    public function show(MataPelajaran $matapelajaran)
    {
        return redirect()->route('matapelajaran.edit', $matapelajaran);
    }

    public function edit(MataPelajaran $matapelajaran)
    {
        return view('pages.mata-pelajaran.edit', compact('matapelajaran'));
    }

    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $matapelajaran)
    {
        $validated = $request->validated();
        $matapelajaran->update($validated);

        alert()->success(
            'Diperbarui!',
            'Mata Pelajaran <strong>' . e($matapelajaran->nama_mata_pelajaran) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }

    public function destroy(MataPelajaran $matapelajaran)
    {
        $nama = $matapelajaran->nama_mata_pelajaran;
        $matapelajaran->delete();

        alert()->success(
            'Dihapus!',
            'Mata Pelajaran <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }
}
