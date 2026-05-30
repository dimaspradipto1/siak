<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\DataTables\PegawaiDataTable;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
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
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PegawaiExport, 'Data_Pegawai_'.date('Ymd').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\PegawaiImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Pegawai berhasil diimport.');
        return redirect()->route('pegawai.index');
    }

    public function template()
    {
        $headers = [['NIP/NIK', 'Nama Pegawai', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'No HP', 'Alamat']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_Pegawai.xlsx');
    }

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
