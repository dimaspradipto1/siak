<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Http\Requests\StoreEkstrakurikulerRequest;
use App\Http\Requests\UpdateEkstrakurikulerRequest;
use App\DataTables\EkstrakurikulerDataTable;

class EkstrakurikulerController extends Controller
{
    public function index(EkstrakurikulerDataTable $dataTable)
    {
        return $dataTable->render('pages.ekstrakurikuler.index');
    }

    public function create()
    {
        return view('pages.ekstrakurikuler.create');
    }

    public function store(StoreEkstrakurikulerRequest $request)
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

    public function update(UpdateEkstrakurikulerRequest $request, Ekstrakurikuler $ekstrakurikuler)
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
}
