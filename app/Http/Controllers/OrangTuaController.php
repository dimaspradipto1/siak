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
