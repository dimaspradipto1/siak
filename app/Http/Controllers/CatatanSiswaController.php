<?php

namespace App\Http\Controllers;

use App\Models\CatatanSiswa;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\JenisCatatan;
use App\Http\Requests\StoreCatatanSiswaRequest;
use App\Http\Requests\UpdateCatatanSiswaRequest;
use App\DataTables\CatatanSiswaDataTable;

class CatatanSiswaController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;
    public function index(CatatanSiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.catatan-siswa.index');
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $gurus = Guru::with('pegawai')->get();
        $semesters = Semester::all();
        $tahunAjarans = TahunAjaran::all();
        $jenisCatatans = JenisCatatan::all();
        return view('pages.catatan-siswa.create', compact('siswas', 'gurus', 'semesters', 'tahunAjarans', 'jenisCatatans'));
    }

    public function store(StoreCatatanSiswaRequest $request)
    {
        $validated = $request->validated();
        CatatanSiswa::create($validated);

        alert()->success(
            'Berhasil!',
            'Catatan siswa berhasil ditambahkan.'
        );

        return redirect()->route('catatansiswa.index');
    }

    public function show(CatatanSiswa $catatansiswa)
    {
        return redirect()->route('catatansiswa.edit', $catatansiswa);
    }

    public function edit(CatatanSiswa $catatansiswa)
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $gurus = Guru::with('pegawai')->get();
        $semesters = Semester::all();
        $tahunAjarans = TahunAjaran::all();
        $jenisCatatans = JenisCatatan::all();
        return view('pages.catatan-siswa.edit', compact('catatansiswa', 'siswas', 'gurus', 'semesters', 'tahunAjarans', 'jenisCatatans'));
    }

    public function update(UpdateCatatanSiswaRequest $request, CatatanSiswa $catatansiswa)
    {
        $validated = $request->validated();
        $catatansiswa->update($validated);

        alert()->success(
            'Diperbarui!',
            'Catatan siswa berhasil diperbarui.'
        );

        return redirect()->route('catatansiswa.index');
    }

    public function destroy(CatatanSiswa $catatansiswa)
    {
        $catatansiswa->delete();

        alert()->success(
            'Dihapus!',
            'Catatan siswa berhasil dihapus.'
        );

        return redirect()->route('catatansiswa.index');
    }
}
