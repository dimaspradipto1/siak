<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\DataTables\KelasDataTable;

class KelasController extends Controller
{
    public function index(KelasDataTable $dataTable)
    {
        return $dataTable->render('pages.kelas.index');
    }

    public function create()
    {
        return view('pages.kelas.create');
    }

    public function store(StoreKelasRequest $request)
    {
        $validated = $request->validated();
        $kelas = Kelas::create($validated);

        alert()->success(
            'Berhasil!',
            'Kelas <strong>' . e($kelas->nama_kelas) . '</strong> berhasil ditambahkan.'
        )->html();

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

    public function update(UpdateKelasRequest $request, Kelas $kela)
    {
        $validated = $request->validated();
        $kela->update($validated);

        alert()->success(
            'Diperbarui!',
            'Kelas <strong>' . e($kela->nama_kelas) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('kelas.index');
    }

    public function destroy(Kelas $kela)
    {
        $nama = $kela->nama_kelas;
        $kela->delete();

        alert()->success(
            'Dihapus!',
            'Kelas <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('kelas.index');
    }
}
