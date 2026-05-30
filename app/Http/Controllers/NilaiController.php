<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;
use App\DataTables\NilaiDataTable;

class NilaiController extends Controller
{
    public function index(NilaiDataTable $dataTable)
    {
        return $dataTable->render('pages.nilai.index');
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->get();
        $mapels = MataPelajaran::all();
        $semesters = Semester::all();
        $tahunAjarans = TahunAjaran::all();
        return view('pages.nilai.create', compact('siswas', 'mapels', 'semesters', 'tahunAjarans'));
    }

    public function store(StoreNilaiRequest $request)
    {
        $validated = $request->validated();
        Nilai::create($validated);

        alert()->success(
            'Berhasil!',
            'Data nilai berhasil ditambahkan.'
        );

        return redirect()->route('nilai.index');
    }

    public function show(Nilai $nilai)
    {
        return redirect()->route('nilai.edit', $nilai);
    }

    public function edit(Nilai $nilai)
    {
        $siswas = Siswa::with('kelas')->get();
        $mapels = MataPelajaran::all();
        $semesters = Semester::all();
        $tahunAjarans = TahunAjaran::all();
        return view('pages.nilai.edit', compact('nilai', 'siswas', 'mapels', 'semesters', 'tahunAjarans'));
    }

    public function update(UpdateNilaiRequest $request, Nilai $nilai)
    {
        $validated = $request->validated();
        $nilai->update($validated);

        alert()->success(
            'Diperbarui!',
            'Data nilai berhasil diperbarui.'
        );

        return redirect()->route('nilai.index');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        alert()->success(
            'Dihapus!',
            'Data nilai berhasil dihapus.'
        );

        return redirect()->route('nilai.index');
    }
}
