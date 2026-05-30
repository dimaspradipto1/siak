<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Http\Requests\StoreWaliKelasRequest;
use App\Http\Requests\UpdateWaliKelasRequest;
use App\DataTables\WaliKelasDataTable;

class WaliKelasController extends Controller
{
    public function index(WaliKelasDataTable $dataTable)
    {
        return $dataTable->render('pages.wali-kelas.index');
    }

    public function create()
    {
        $gurus = Guru::with('pegawai')->get();
        $kelas = Kelas::all();
        // Hanya ambil tahun ajaran yang aktif untuk default form, tapi tetap passing semua jika diperlukan
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.wali-kelas.create', compact('gurus', 'kelas', 'tahunAjarans'));
    }

    public function store(StoreWaliKelasRequest $request)
    {
        $validated = $request->validated();
        $waliKelas = WaliKelas::create($validated);

        $guru = $waliKelas->guru->pegawai->nama_pegawai ?? 'Guru';
        $kelasNama = $waliKelas->kelas->nama_kelas ?? 'Kelas';

        alert()->success(
            'Berhasil!',
            'Wali Kelas <strong>' . e($guru) . '</strong> untuk kelas <strong>' . e($kelasNama) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('walikelas.index');
    }

    public function show(WaliKelas $walikela)
    {
        return redirect()->route('walikelas.edit', $walikela);
    }

    public function edit(WaliKelas $walikela)
    {
        $gurus = Guru::with('pegawai')->get();
        $kelas = Kelas::all();
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.wali-kelas.edit', ['waliKelas' => $walikela, 'gurus' => $gurus, 'kelas' => $kelas, 'tahunAjarans' => $tahunAjarans]);
    }

    public function update(UpdateWaliKelasRequest $request, WaliKelas $walikela)
    {
        $validated = $request->validated();
        $walikela->update($validated);

        $guru = $walikela->guru->pegawai->nama_pegawai ?? 'Guru';
        $kelasNama = $walikela->kelas->nama_kelas ?? 'Kelas';

        alert()->success(
            'Diperbarui!',
            'Wali Kelas <strong>' . e($guru) . '</strong> untuk kelas <strong>' . e($kelasNama) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('walikelas.index');
    }

    public function destroy(WaliKelas $walikela)
    {
        $guru = $walikela->guru->pegawai->nama_pegawai ?? 'Guru';
        $kelasNama = $walikela->kelas->nama_kelas ?? 'Kelas';
        
        $walikela->delete();

        alert()->success(
            'Dihapus!',
            'Penugasan Wali Kelas <strong>' . e($guru) . '</strong> untuk kelas <strong>' . e($kelasNama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('walikelas.index');
    }
}
