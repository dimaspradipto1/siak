<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\DataTables\PegawaiDataTable;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Tampilkan daftar pegawai (DataTables).
     */
    public function index(PegawaiDataTable $dataTable)
    {
        return $dataTable->render('pages.pegawai.index');
    }

    /**
     * Tampilkan form tambah pegawai.
     */
    public function create()
    {
        return view('pages.pegawai.create');
    }

    /**
     * Simpan data pegawai baru ke database.
     */
    public function store(StorePegawaiRequest $request)
    {
        $validated = $request->validated();

        Pegawai::create($validated);

        alert()->success(
            'Berhasil!',
            'Data pegawai <strong>' . e($validated['nama_pegawai']) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('pegawai.index');
    }

    /**
     * Tampilkan detail pegawai (redirect ke edit).
     */
    public function show(Pegawai $pegawai)
    {
        return redirect()->route('pegawai.edit', $pegawai);
    }

    /**
     * Tampilkan form edit pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pages.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update data pegawai di database.
     */
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        $validated = $request->validated();

        $pegawai->update($validated);

        alert()->success(
            'Diperbarui!',
            'Data pegawai <strong>' . e($pegawai->nama_pegawai) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('pegawai.index');
    }

    /**
     * Hapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        $nama = $pegawai->nama_pegawai;
        $pegawai->delete();

        alert()->success(
            'Dihapus!',
            'Data pegawai <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('pegawai.index');
    }
}
