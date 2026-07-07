<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Http\Requests\JabatanRequest;
use App\DataTables\JabatanDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    use \App\Traits\AuthorizeMasterData;

    /**
     * Display a listing of the resource.
     */
    public function index(JabatanDataTable $dataTable)
    {
        return $dataTable->render('pages.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JabatanRequest $request)
    {
        $validated = $request->validated();
        Jabatan::create($validated);

        Alert::success('success', 'Jabatan berhasil ditambahkan.');

        return redirect()->route('jabatan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return redirect()->route('jabatan.edit', $jabatan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return view('pages.jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JabatanRequest $request, Jabatan $jabatan)
    {
        $validated = $request->validated();
        $jabatan->update($validated);

        Alert::success('success', 'Jabatan berhasil diperbarui.');

        return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        Alert::success('success', 'Jabatan berhasil dihapus.');

        return redirect()->route('jabatan.index');
    }
}
