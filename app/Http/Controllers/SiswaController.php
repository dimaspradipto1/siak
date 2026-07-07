<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Kelas;
use App\Models\Ekstrakurikuler;
use App\Http\Requests\SiswaRequest;

use App\DataTables\SiswaDataTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;

class SiswaController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
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

    public function store(SiswaRequest $request)
    {
        $validated = $request->validated();
        $siswa = Siswa::create($validated);

        alert()->html(
            'Berhasil!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil ditambahkan.',
            'success'
        );

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

    public function update(SiswaRequest $request, Siswa $siswa)
    {
        $validated = $request->validated();
        $siswa->update($validated);

        alert()->html(
            'Diperbarui!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('siswa.index');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaExport, 'Data_Siswa_'.date('Ymd').'.xlsx');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SiswaImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Siswa berhasil diimport.');
        return redirect()->route('siswa.index');
    }

    public function template()
    {
        $headers = [['NISN', 'NIS', 'Nama Siswa', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat', 'Nama Kelas', 'Nama Ibu Kandung']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_Siswa.xlsx');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama_siswa;
        $siswa->delete();

        alert()->html(
            'Dihapus!',
            'Data Siswa <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('siswa.index');
    }
}
