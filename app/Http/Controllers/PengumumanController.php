<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\MataPelajaran;
use App\Http\Requests\PengumumanRequest;

use App\DataTables\PengumumanDataTable;

class PengumumanController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;
    public function index(PengumumanDataTable $dataTable)
    {
        $kelas = \App\Models\Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::query()->get();
        $mapels = \App\Models\MataPelajaran::query()->distinct()->orderBy('nama_mata_pelajaran', 'asc')->get(['nama_mata_pelajaran']);
        
        return $dataTable->render('pages.pengumuman.index', compact('kelas', 'tahunAjarans', 'mapels'));
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::all();
        $semesters = \App\Models\Semester::all();
        $matapelajarans = \App\Models\MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return view('pages.pengumuman.create', compact('kelas', 'tahunAjarans', 'semesters', 'matapelajarans'));
    }

    public function store(PengumumanRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id(); // assign to current user
        $pengumuman = Pengumuman::create($validated);

        alert()->html(
            'Berhasil!',
            'Pengumuman <strong>' . e($pengumuman->judul) . '</strong> berhasil dipublikasikan.',
            'success'
        );

        return redirect()->route('pengumuman.index');
    }

    public function show(Pengumuman $pengumuman)
    {
        return redirect()->route('pengumuman.edit', $pengumuman);
    }

    public function edit(Pengumuman $pengumuman)
    {
        $kelas = \App\Models\Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::all();
        $semesters = \App\Models\Semester::all();
        $matapelajarans = \App\Models\MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return view('pages.pengumuman.edit', compact('pengumuman', 'kelas', 'tahunAjarans', 'semesters', 'matapelajarans'));
    }

    public function update(PengumumanRequest $request, Pengumuman $pengumuman)
    {
        $validated = $request->validated();
        $pengumuman->update($validated);

        alert()->html(
            'Diperbarui!',
            'Pengumuman <strong>' . e($pengumuman->judul) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('pengumuman.index');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();

        alert()->html(
            'Dihapus!',
            'Pengumuman <strong>' . e($judul) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('pengumuman.index');
    }
}
