<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\DataTables\MataPelajaranDataTable;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('pages.mata-pelajaran.index');
    }

    public function create()
    {
        return view('pages.mata-pelajaran.create');
    }

    public function store(StoreMataPelajaranRequest $request)
    {
        $validated = $request->validated();
        $mapel = MataPelajaran::create($validated);

        alert()->success(
            'Berhasil!',
            'Mata Pelajaran <strong>' . e($mapel->nama_mata_pelajaran) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }

    public function show(MataPelajaran $matapelajaran)
    {
        return redirect()->route('matapelajaran.edit', $matapelajaran);
    }

    public function edit(MataPelajaran $matapelajaran)
    {
        return view('pages.mata-pelajaran.edit', compact('matapelajaran'));
    }

    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $matapelajaran)
    {
        $validated = $request->validated();
        $matapelajaran->update($validated);

        alert()->success(
            'Diperbarui!',
            'Mata Pelajaran <strong>' . e($matapelajaran->nama_mata_pelajaran) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MataPelajaranExport, 'Data_Mata_Pelajaran_'.date('Ymd').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\MataPelajaranImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Mata Pelajaran berhasil diimport.');
        return redirect()->route('matapelajaran.index');
    }

    public function template()
    {
        $headers = [['Kode Mapel', 'Nama Mapel', 'KKM']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_MataPelajaran.xlsx');
    }

    public function destroy(MataPelajaran $matapelajaran)
    {
        $nama = $matapelajaran->nama_mata_pelajaran;
        $matapelajaran->delete();

        alert()->success(
            'Dihapus!',
            'Mata Pelajaran <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('matapelajaran.index');
    }
}
