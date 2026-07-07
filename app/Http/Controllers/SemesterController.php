<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Http\Requests\SemesterRequest;

use App\DataTables\SemesterDataTable;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    /**
     * Tampilkan daftar semester (DataTables).
     */
    public function index(SemesterDataTable $dataTable)
    {
        return $dataTable->render('pages.semester.index');
    }

    /**
     * Tampilkan form tambah semester.
     */
    public function create()
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.semester.create', compact('tahunAjarans'));
    }

    /**
     * Simpan data semester baru ke database.
     */
    public function store(SemesterRequest $request)
    {
        $validated = $request->validated();

        $semester = Semester::create($validated);

        $nama = $semester->nama_semester;
        $ta   = $semester->tahunAjaran;
        $label = $nama . ' - ' . ($ta ? $ta->nama_tahun_ajaran : '');

        alert()->html(
            'Berhasil!',
            'Semester <strong>' . e($label) . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('semester.index');
    }

    /**
     * Tampilkan detail semester (redirect ke edit).
     */
    public function show(Semester $semester)
    {
        return redirect()->route('semester.edit', $semester);
    }

    /**
     * Tampilkan form edit semester.
     */
    public function edit(Semester $semester)
    {
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.semester.edit', compact('semester', 'tahunAjarans'));
    }

    /**
     * Update data semester di database.
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        $validated = $request->validated();

        $semester->update($validated);

        $nama = $semester->nama_semester;
        $ta   = $semester->tahunAjaran;
        $label = $nama . ' - ' . ($ta ? $ta->nama_tahun_ajaran : '');

        alert()->html(
            'Diperbarui!',
            'Semester <strong>' . e($label) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('semester.index');
    }

    /**
     * Hapus data semester dari database.
     */
    public function destroy(Semester $semester)
    {
        $nama = $semester->nama_semester;
        $ta   = $semester->tahunAjaran;
        $label = $nama . ' - ' . ($ta ? $ta->nama_tahun_ajaran : '');

        $semester->delete();

        alert()->html(
            'Dihapus!',
            'Semester <strong>' . e($label) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('semester.index');
    }
}
