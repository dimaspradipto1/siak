<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Http\Requests\StoreOrangTuaRequest;
use App\Http\Requests\UpdateOrangTuaRequest;
use App\DataTables\OrangTuaDataTable;

class OrangTuaController extends Controller
{
    public function index(OrangTuaDataTable $dataTable)
    {
        return $dataTable->render('pages.orang-tua.index');
    }

    public function create()
    {
        return view('pages.orang-tua.create');
    }

    public function store(StoreOrangTuaRequest $request)
    {
        $validated = $request->validated();
        $orangTua = OrangTua::create($validated);

        $nama = $orangTua->nama_ayah ?? $orangTua->nama_ibu ?? 'Orang Tua';

        alert()->success(
            'Berhasil!',
            'Data Orang Tua <strong>' . e($nama) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('orang-tua.index');
    }

    public function show(OrangTua $orangTua)
    {
        return redirect()->route('orang-tua.edit', $orangTua);
    }

    public function edit(OrangTua $orangTua)
    {
        return view('pages.orang-tua.edit', compact('orangTua'));
    }

    public function update(UpdateOrangTuaRequest $request, OrangTua $orangTua)
    {
        $validated = $request->validated();
        $orangTua->update($validated);

        $nama = $orangTua->nama_ayah ?? $orangTua->nama_ibu ?? 'Orang Tua';

        alert()->success(
            'Diperbarui!',
            'Data Orang Tua <strong>' . e($nama) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('orang-tua.index');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\OrangTuaExport, 'Data_Orang_Tua_'.date('Ymd').'.xlsx');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\OrangTuaImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Orang Tua berhasil diimport.');
        return redirect()->route('orang-tua.index');
    }

    public function template()
    {
        $headers = [['Username Akun', 'Nama Ayah', 'Pekerjaan Ayah', 'No HP Ayah', 'Nama Ibu', 'Pekerjaan Ibu', 'No HP Ibu', 'Alamat']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_OrangTua.xlsx');
    }

    public function destroy(OrangTua $orangTua)
    {
        $nama = $orangTua->nama_ayah ?? $orangTua->nama_ibu ?? 'Orang Tua';
        $orangTua->delete();

        alert()->success(
            'Dihapus!',
            'Data Orang Tua <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('orang-tua.index');
    }
}
