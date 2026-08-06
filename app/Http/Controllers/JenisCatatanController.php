<?php

namespace App\Http\Controllers;

use App\Models\JenisCatatan;
use App\Http\Requests\JenisCatatanRequest;

use App\DataTables\JenisCatatanDataTable;

class JenisCatatanController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(JenisCatatanDataTable $dataTable)
    {
        return $dataTable->render('pages.jenis-catatan.index');
    }

    public function create()
    {
        return view('pages.jenis-catatan.create');
    }

    public function store(JenisCatatanRequest $request)
    {
        $validated = $request->validated();
        $jenis = JenisCatatan::create($validated);

        alert()->html(
            'Berhasil!',
            'Jenis Catatan <strong>' . e($jenis->nama_jenis_catatan) . '</strong> berhasil ditambahkan.',
            'success'
        );

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

    public function update(JenisCatatanRequest $request, JenisCatatan $jeniscatatan)
    {
        $validated = $request->validated();
        $jeniscatatan->update($validated);

        alert()->html(
            'Diperbarui!',
            'Jenis Catatan <strong>' . e($jeniscatatan->nama_jenis_catatan) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('jeniscatatan.index');
    }

    public function destroy(JenisCatatan $jeniscatatan)
    {
        $nama = $jeniscatatan->nama_jenis_catatan;
        $jeniscatatan->delete();

        alert()->html(
            'Dihapus!',
            'Jenis Catatan <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('jeniscatatan.index');
    }
}
