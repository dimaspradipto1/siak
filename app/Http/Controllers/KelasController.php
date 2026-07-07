<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\KelasRequest;
use App\DataTables\KelasDataTable;

class KelasController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(KelasDataTable $dataTable)
    {
        return $dataTable->render('pages.kelas.index');
    }

    public function create()
    {
        return view('pages.kelas.create');
    }

    public function store(KelasRequest $request)
    {
        $validated = $request->validated();
        $kelas = Kelas::create($validated);

        alert()->html(
            'Berhasil!',
            'Kelas <strong>' . e($kelas->nama_kelas) . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('kelas.index');
    }

    public function show(Kelas $kela)
    {
        return redirect()->route('kelas.edit', $kela);
    }

    public function edit(Kelas $kela)
    {
        return view('pages.kelas.edit', ['kelas' => $kela]);
    }

    public function update(KelasRequest $request, Kelas $kela)
    {
        $validated = $request->validated();
        $kela->update($validated);

        alert()->html(
            'Diperbarui!',
            'Kelas <strong>' . e($kela->nama_kelas) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('kelas.index');
    }

    public function destroy(Kelas $kela)
    {
        $nama = $kela->nama_kelas;
        $kela->delete();

        alert()->html(
            'Dihapus!',
            'Kelas <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('kelas.index');
    }
}
