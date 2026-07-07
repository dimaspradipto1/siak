<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Http\Requests\EkstrakurikulerRequest;

use App\DataTables\EkstrakurikulerDataTable;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\PembagianKelas;
use App\Models\SiswaEkstrakurikuler;

class EkstrakurikulerController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(EkstrakurikulerDataTable $dataTable)
    {
        if (auth()->check() && auth()->user()->roles === 'wali kelas') {
            return redirect()->route('ekstrakurikuler.siswa');
        }
        return $dataTable->render('pages.ekstrakurikuler.index');
    }

    public function create()
    {
        return view('pages.ekstrakurikuler.create');
    }

    public function store(EkstrakurikulerRequest $request)
    {
        $validated = $request->validated();
        $ekskul = Ekstrakurikuler::create($validated);

        alert()->success(
            'Berhasil!',
            'Ekstrakurikuler <strong>' . e($ekskul->nama_ekskul) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('ekstrakurikuler.index');
    }

    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        return redirect()->route('ekstrakurikuler.edit', $ekstrakurikuler);
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('pages.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function update(EkstrakurikulerRequest $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $validated = $request->validated();
        $ekstrakurikuler->update($validated);

        alert()->success(
            'Diperbarui!',
            'Ekstrakurikuler <strong>' . e($ekstrakurikuler->nama_ekskul) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('ekstrakurikuler.index');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        $nama = $ekstrakurikuler->nama_ekskul;
        $ekstrakurikuler->delete();

        alert()->success(
            'Dihapus!',
            'Ekstrakurikuler <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('ekstrakurikuler.index');
    }

    public function ekskulSiswa(\Illuminate\Http\Request $request)
    {
        $kelas = \App\Models\Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::query()->get();
        $ekskuls = Ekstrakurikuler::query()->orderBy('nama_ekskul', 'asc')->get();

        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSemName = $request->get('semester_name');
        $selectedKelas = $request->get('kelas_id');

        if (!$selectedTa) {
            $activeTa = \App\Models\TahunAjaran::query()->where('status', 'Aktif')->first() ?? \App\Models\TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }
        if (!$selectedSemName) {
            $selectedSemName = 'Semester 1 (Ganjil)';
        }

        $semester = null;
        if ($selectedTa && $selectedSemName) {
            $semester = \App\Models\Semester::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('nama_semester', $selectedSemName)
                ->first();
        }
        $selectedSem = $semester ? $semester->id : null;

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas) {
            $siswaIds = \App\Models\PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $students = \App\Models\Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            // Load currently assigned extracurriculars for each student in this semester/year
            foreach ($students as $siswa) {
                $siswa->assigned_ekskuls = \App\Models\SiswaEkstrakurikuler::query()
                    ->where('siswa_id', $siswa->id)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->where('semester_id', $selectedSem)
                    ->pluck('ekstrakurikuler_id')
                    ->toArray();
            }
        }

        return view('pages.ekstrakurikuler.siswa', compact('kelas', 'tahunAjarans', 'ekskuls', 'selectedTa', 'selectedSemName', 'selectedSem', 'selectedKelas', 'students'));
    }

    public function ekskulSiswaSave(\Illuminate\Http\Request $request)
    {
        $selectedTa = $request->input('tahun_ajaran_id');
        $selectedSem = $request->input('semester_id');
        $ekskulAssignments = $request->input('ekskul', []); // map of student_id => array of ekskul_ids

        if (!$selectedTa || !$selectedSem) {
            alert()->error('Error', 'Tahun Ajaran dan Semester wajib diisi.');
            return redirect()->back();
        }

        foreach ($ekskulAssignments as $siswaId => $ekskulIds) {
            // Delete existing assignments for this student in this semester/year
            \App\Models\SiswaEkstrakurikuler::query()
                ->where('siswa_id', $siswaId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->delete();

            // Save new assignments
            if (is_array($ekskulIds)) {
                foreach ($ekskulIds as $ekskulId) {
                    if ($ekskulId) {
                        \App\Models\SiswaEkstrakurikuler::query()->create([
                            'siswa_id' => $siswaId,
                            'ekstrakurikuler_id' => $ekskulId,
                            'tahun_ajaran_id' => $selectedTa,
                            'semester_id' => $selectedSem,
                        ]);
                    }
                }
            }
        }

        alert()->success('Berhasil!', 'Data ekstrakurikuler siswa berhasil disimpan.')->html();
        return redirect()->back();
    }
}
