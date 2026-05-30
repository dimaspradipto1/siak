<?php

namespace App\Http\Controllers;

use App\Models\JenisKehadiran;
use App\Http\Requests\StoreJenisKehadiranRequest;
use App\Http\Requests\UpdateJenisKehadiranRequest;
use App\DataTables\JenisKehadiranDataTable;

class JenisKehadiranController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(JenisKehadiranDataTable $dataTable)
    {
        return $dataTable->render('pages.jenis-kehadiran.index');
    }

    public function create()
    {
        return view('pages.jenis-kehadiran.create');
    }

    public function store(StoreJenisKehadiranRequest $request)
    {
        $validated = $request->validated();
        $jenis = JenisKehadiran::create($validated);

        alert()->success(
            'Berhasil!',
            'Jenis Kehadiran <strong>' . e($jenis->nama_kehadiran) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('jeniskehadiran.index');
    }

    public function show(JenisKehadiran $jeniskehadiran)
    {
        return redirect()->route('jeniskehadiran.edit', $jeniskehadiran);
    }

    public function edit(JenisKehadiran $jeniskehadiran)
    {
        return view('pages.jenis-kehadiran.edit', compact('jeniskehadiran'));
    }

    public function update(UpdateJenisKehadiranRequest $request, JenisKehadiran $jeniskehadiran)
    {
        $validated = $request->validated();
        $jeniskehadiran->update($validated);

        alert()->success(
            'Diperbarui!',
            'Jenis Kehadiran <strong>' . e($jeniskehadiran->nama_kehadiran) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('jeniskehadiran.index');
    }

    public function destroy(JenisKehadiran $jeniskehadiran)
    {
        $nama = $jeniskehadiran->nama_kehadiran;
        $jeniskehadiran->delete();

        alert()->success(
            'Dihapus!',
            'Jenis Kehadiran <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('jeniskehadiran.index');
    }
}
