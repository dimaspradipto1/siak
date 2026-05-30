<?php

namespace App\Http\Controllers;

use App\Models\JenisCatatan;
use App\Http\Requests\StoreJenisCatatanRequest;
use App\Http\Requests\UpdateJenisCatatanRequest;
use App\DataTables\JenisCatatanDataTable;

class JenisCatatanController extends Controller
{
    public function index(JenisCatatanDataTable $dataTable)
    {
        return $dataTable->render('pages.jenis-catatan.index');
    }

    public function create()
    {
        return view('pages.jenis-catatan.create');
    }

    public function store(StoreJenisCatatanRequest $request)
    {
        $validated = $request->validated();
        $jenis = JenisCatatan::create($validated);

        alert()->success(
            'Berhasil!',
            'Jenis Catatan <strong>' . e($jenis->nama_jenis_catatan) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('jeniscatatan.index');
    }

    public function show(JenisCatatan $jeniscatatan)
    {
        return redirect()->route('jeniscatatan.edit', $jeniscatatan);
    }

    public function edit(JenisCatatan $jeniscatatan)
    {
        return view('pages.jenis-catatan.edit', compact('jeniscatatan'));
    }

    public function update(UpdateJenisCatatanRequest $request, JenisCatatan $jeniscatatan)
    {
        $validated = $request->validated();
        $jeniscatatan->update($validated);

        alert()->success(
            'Diperbarui!',
            'Jenis Catatan <strong>' . e($jeniscatatan->nama_jenis_catatan) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('jeniscatatan.index');
    }

    public function destroy(JenisCatatan $jeniscatatan)
    {
        $nama = $jeniscatatan->nama_jenis_catatan;
        $jeniscatatan->delete();

        alert()->success(
            'Dihapus!',
            'Jenis Catatan <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('jeniscatatan.index');
    }
}
