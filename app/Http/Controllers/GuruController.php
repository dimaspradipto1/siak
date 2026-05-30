<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pegawai;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\DataTables\GuruDataTable;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Tampilkan daftar guru (DataTables).
     */
    public function index(GuruDataTable $dataTable)
    {
        return $dataTable->render('pages.guru.index');
    }

    /**
     * Tampilkan form tambah guru.
     */
    public function create()
    {
        // Hanya ambil pegawai yang jabatannya berkaitan dengan guru/kepala sekolah atau belum terdaftar sebagai guru
        $pegawais = Pegawai::whereDoesntHave('guru')->orderBy('nama_pegawai')->get();

        return view('pages.guru.create', compact('pegawais'));
    }

    /**
     * Simpan data guru baru ke database.
     */
    public function store(StoreGuruRequest $request)
    {
        $validated = $request->validated();

        $guru = Guru::create($validated);
        
        // Ambil nama pegawai untuk notifikasi
        $nama = $guru->pegawai ? $guru->pegawai->nama_pegawai : $guru->nip_guru;

        alert()->success(
            'Berhasil!',
            'Guru <strong>' . e($nama) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('guru.index');
    }

    /**
     * Tampilkan detail guru (redirect ke edit).
     */
    public function show(Guru $guru)
    {
        return redirect()->route('guru.edit', $guru);
    }

    /**
     * Tampilkan form edit guru.
     */
    public function edit(Guru $guru)
    {
        // Ambil pegawai yang belum menjadi guru, ATAU yang sedang di-edit saat ini
        $pegawais = Pegawai::whereDoesntHave('guru')
            ->orWhere('id', $guru->pegawai_id)
            ->orderBy('nama_pegawai')
            ->get();

        return view('pages.guru.edit', compact('guru', 'pegawais'));
    }

    /**
     * Update data guru di database.
     */
    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $validated = $request->validated();

        $guru->update($validated);

        $nama = $guru->pegawai ? $guru->pegawai->nama_pegawai : $guru->nip_guru;

        alert()->success(
            'Diperbarui!',
            'Data guru <strong>' . e($nama) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('guru.index');
    }

    /**
     * Hapus data guru dari database.
     */
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\GuruExport, 'Data_Guru_'.date('Ymd').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\GuruImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Guru berhasil diimport.');
        return redirect()->route('guru.index');
    }

    public function template()
    {
        $headers = [['NIP Pegawai', 'NIP Guru', 'Golongan', 'Pendidikan Terakhir']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_Guru.xlsx');
    }

    public function destroy(Guru $guru)
    {
        $nama = $guru->pegawai ? $guru->pegawai->nama_pegawai : $guru->nip_guru;
        
        $guru->delete();

        alert()->success(
            'Dihapus!',
            'Data guru <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('guru.index');
    }
}
