<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Http\Requests\StoreTahunAjaranRequest;
use App\Http\Requests\UpdateTahunAjaranRequest;
use App\DataTables\TahunAjaranDataTable;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    /**
     * Tampilkan daftar tahun ajaran (DataTables).
     */
    public function index(TahunAjaranDataTable $dataTable)
    {
        return $dataTable->render('pages.tahun-ajaran.index');
    }

    /**
     * Tampilkan form tambah tahun ajaran.
     */
    public function create()
    {
        return view('pages.tahun-ajaran.create');
    }

    /**
     * Simpan data tahun ajaran baru ke database.
     */
    public function store(StoreTahunAjaranRequest $request)
    {
        $validated = $request->validated();

        // Jika status diset Aktif, nonaktifkan semua tahun ajaran lain
        if ($validated['status'] === 'Aktif') {
            TahunAjaran::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);
        }

        $tahunAjaran = TahunAjaran::create($validated);

        $nama = $tahunAjaran->tahun_mulai . '/' . $tahunAjaran->tahun_selesai;

        alert()->success(
            'Berhasil!',
            'Tahun Ajaran <strong>' . e($nama) . '</strong> berhasil ditambahkan.'
        )->html();

        return redirect()->route('tahun-ajaran.index');
    }

    /**
     * Tampilkan detail tahun ajaran (redirect ke edit).
     */
    public function show(TahunAjaran $tahun_ajaran)
    {
        return redirect()->route('tahun-ajaran.edit', $tahun_ajaran);
    }

    /**
     * Tampilkan form edit tahun ajaran.
     */
    public function edit(TahunAjaran $tahun_ajaran)
    {
        return view('pages.tahun-ajaran.edit', compact('tahun_ajaran'));
    }

    /**
     * Update data tahun ajaran di database.
     */
    public function update(UpdateTahunAjaranRequest $request, TahunAjaran $tahun_ajaran)
    {
        $validated = $request->validated();

        // Jika status diset Aktif, nonaktifkan semua tahun ajaran lain
        if ($validated['status'] === 'Aktif') {
            TahunAjaran::where('status', 'Aktif')
                ->where('id', '!=', $tahun_ajaran->id)
                ->update(['status' => 'Tidak Aktif']);
        }

        $tahun_ajaran->update($validated);

        $nama = $tahun_ajaran->tahun_mulai . '/' . $tahun_ajaran->tahun_selesai;

        alert()->success(
            'Diperbarui!',
            'Tahun Ajaran <strong>' . e($nama) . '</strong> berhasil diperbarui.'
        )->html();

        return redirect()->route('tahun-ajaran.index');
    }

    /**
     * Hapus data tahun ajaran dari database.
     */
    public function destroy(TahunAjaran $tahun_ajaran)
    {
        $nama = $tahun_ajaran->tahun_mulai . '/' . $tahun_ajaran->tahun_selesai;

        $tahun_ajaran->delete();

        alert()->success(
            'Dihapus!',
            'Tahun Ajaran <strong>' . e($nama) . '</strong> berhasil dihapus.'
        )->html();

        return redirect()->route('tahun-ajaran.index');
    }
}
