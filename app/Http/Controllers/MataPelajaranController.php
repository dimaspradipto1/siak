<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Guru;
use App\Http\Requests\MataPelajaranRequest;
use App\DataTables\MataPelajaranDataTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MataPelajaranController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('pages.mata-pelajaran.index');
    }

    public function create()
    {
        $kelas = \App\Models\Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::all();
        $semesters = \App\Models\Semester::all();
        $gurus = \App\Models\Guru::with('pegawai')->get();
        return view('pages.mata-pelajaran.create', compact('kelas', 'tahunAjarans', 'semesters', 'gurus'));
    }

    public function store(MataPelajaranRequest $request)
    {
        $validated = $request->validated();
        $mapel = MataPelajaran::create($validated);

        alert()->html(
            'Berhasil!',
            'Mata Pelajaran <strong>' . e($mapel->nama_mata_pelajaran) . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('matapelajaran.index');
    }

    public function show(MataPelajaran $matapelajaran)
    {
        $matapelajaran->load(['kelas', 'tahunAjaran', 'semester', 'guru.pegawai']);
        return view('pages.mata-pelajaran.show', compact('matapelajaran'));
    }

    public function edit(MataPelajaran $matapelajaran)
    {
        $kelas = \App\Models\Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = \App\Models\TahunAjaran::all();
        $semesters = \App\Models\Semester::all();
        $gurus = \App\Models\Guru::with('pegawai')->get();
        return view('pages.mata-pelajaran.edit', compact('matapelajaran', 'kelas', 'tahunAjarans', 'semesters', 'gurus'));
    }

    public function update(MataPelajaranRequest $request, MataPelajaran $matapelajaran)
    {
        $validated = $request->validated();
        $matapelajaran->update($validated);

        alert()->html(
            'Diperbarui!',
            'Mata Pelajaran <strong>' . e($matapelajaran->nama_mata_pelajaran) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('matapelajaran.index');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\MataPelajaranExport, 'Data_Mata_Pelajaran_'.date('Ymd').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new \App\Imports\MataPelajaranImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Mata Pelajaran berhasil diimport.');
        return redirect()->route('matapelajaran.index');
    }

    public function template()
    {
        $headers = [['Kelas', 'Tahun Ajaran', 'Semester', 'Kode Mapel', 'Nama Mapel', 'KKM', 'Nama Guru', 'Hari Mengajar', 'Jam Mengajar']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return Excel::download($export, 'Template_Import_MataPelajaran.xlsx');
    }

    public function destroy(MataPelajaran $matapelajaran)
    {
        $nama = $matapelajaran->nama_mata_pelajaran;
        $matapelajaran->delete();

        alert()->html(
            'Dihapus!',
            'Mata Pelajaran <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('matapelajaran.index');
    }
}
