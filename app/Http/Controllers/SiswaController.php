<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Kelas;
use App\Models\Ekstrakurikuler;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\DataTables\SiswaDataTable;

class SiswaController extends Controller
{
    public function index(SiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.siswa.index');
    }

    public function create()
    {
        $orangTuas = OrangTua::all();
        $kelas = Kelas::all();
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('pages.siswa.create', compact('orangTuas', 'kelas', 'ekstrakurikulers'));
    }

    public function store(StoreSiswaRequest $request)
    {
        $validated = $request->validated();
        $siswa = Siswa::create($validated);

        alert()->success(
            'Berhasil!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('siswa.index');
    }

    public function show(Siswa $siswa)
    {
        return redirect()->route('siswa.edit', $siswa);
    }

    public function edit(Siswa $siswa)
    {
        $orangTuas = OrangTua::all();
        $kelas = Kelas::all();
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('pages.siswa.edit', compact('siswa', 'orangTuas', 'kelas', 'ekstrakurikulers'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $validated = $request->validated();
        $siswa->update($validated);

        alert()->success(
            'Diperbarui!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('siswa.index');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama_siswa;
        $siswa->delete();

        alert()->success(
            'Dihapus!',
            'Data Siswa <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('siswa.index');
    }
}
