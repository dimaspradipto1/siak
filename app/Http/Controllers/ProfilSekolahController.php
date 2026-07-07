<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\TahunAjaran;
use App\Http\Requests\ProfilSekolahRequest;
use App\DataTables\ProfilSekolahDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilSekolahController extends Controller
{
    use \App\Traits\AuthorizeMasterData;

    /**
     * Display a listing of the resource.
     */
    public function index(ProfilSekolahDataTable $dataTable)
    {
        return $dataTable->render('pages.profil-sekolah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('pages.profil-sekolah.create', compact('tahunAjarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfilSekolahRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo_sekolah')) {
            $file = $request->file('logo_sekolah');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Ensure destination path exists
            if (!file_exists(public_path('uploads/logo'))) {
                mkdir(public_path('uploads/logo'), 0755, true);
            }
            $file->move(public_path('uploads/logo'), $filename);
            $validated['logo_sekolah'] = 'uploads/logo/' . $filename;
        }

        $profil = ProfilSekolah::create($validated);

        Alert::success('success', 'Profil sekolah berhasil ditambahkan.');

        return redirect()->route('profil-sekolah.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilSekolah $profil_sekolah)
    {
        return redirect()->route('profil-sekolah.edit', $profil_sekolah);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilSekolah $profil_sekolah)
    {
        $tahunAjarans = TahunAjaran::all();
        return view('pages.profil-sekolah.edit', compact('profil_sekolah', 'tahunAjarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfilSekolahRequest $request, ProfilSekolah $profil_sekolah)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo_sekolah')) {
            // Delete old logo file if it exists
            if ($profil_sekolah->logo_sekolah && file_exists(public_path($profil_sekolah->logo_sekolah))) {
                @unlink(public_path($profil_sekolah->logo_sekolah));
            }

            $file = $request->file('logo_sekolah');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads/logo'))) {
                mkdir(public_path('uploads/logo'), 0755, true);
            }
            $file->move(public_path('uploads/logo'), $filename);
            $validated['logo_sekolah'] = 'uploads/logo/' . $filename;
        }

        $profil_sekolah->update($validated);

        Alert::success('success', 'Profil sekolah berhasil diperbarui.');

        return redirect()->route('profil-sekolah.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilSekolah $profil_sekolah)
    {
        if ($profil_sekolah->logo_sekolah && file_exists(public_path($profil_sekolah->logo_sekolah))) {
            @unlink(public_path($profil_sekolah->logo_sekolah));
        }

        $nama = $profil_sekolah->nama_sekolah;
        $profil_sekolah->delete();

        Alert::success('success', 'Profil sekolah berhasil dihapus.');

        return redirect()->route('profil-sekolah.index');
    }
}
