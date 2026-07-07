<?php

namespace App\Http\Controllers;

use App\Models\PembagianKelas;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Http\Requests\PembagianKelasRequest;

use App\DataTables\PembagianKelasDataTable;
use Illuminate\Http\Request;

class PembagianKelasController extends Controller
{
    use \App\Traits\AuthorizeMasterData;

    public function index(PembagianKelasDataTable $dataTable)
    {
        return $dataTable->render('pages.pembagiankelas.index');
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::all();
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.pembagiankelas.create', compact('siswas', 'kelas', 'tahunAjarans'));
    }

    public function store(PembagianKelasRequest $request)
    {
        $validated = $request->validated();
        $pembagianKelas = PembagianKelas::create($validated);

        $siswa = Siswa::find($pembagianKelas->siswa_id);
        if ($siswa) {
            $siswa->update(['kelas_id' => $pembagianKelas->kelas_id]);
        }

        alert()->html(
            'Berhasil!',
            'Pembagian Kelas untuk Siswa <strong>' . e($siswa->nama_siswa ?? 'Siswa') . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('pembagiankelas.index');
    }

    public function show(PembagianKelas $pembagiankela)
    {
        return redirect()->route('pembagiankelas.edit', $pembagiankela);
    }

    public function edit(PembagianKelas $pembagiankela)
    {
        $siswas = Siswa::orderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::all();
        $tahunAjarans = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();

        return view('pages.pembagiankelas.edit', [
            'pembagianKelas' => $pembagiankela,
            'siswas' => $siswas,
            'kelas' => $kelas,
            'tahunAjarans' => $tahunAjarans
        ]);
    }

    public function update(PembagianKelasRequest $request, PembagianKelas $pembagiankela)
    {
        $validated = $request->validated();
        $pembagiankela->update($validated);

        $siswa = Siswa::find($pembagiankela->siswa_id);
        if ($siswa) {
            $siswa->update(['kelas_id' => $pembagiankela->kelas_id]);
        }

        alert()->html(
            'Diperbarui!',
            'Pembagian Kelas untuk Siswa <strong>' . e($siswa->nama_siswa ?? 'Siswa') . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('pembagiankelas.index');
    }

    public function destroy(PembagianKelas $pembagiankela)
    {
        $namaSiswa = $pembagiankela->siswa->nama_siswa ?? 'Siswa';
        $pembagiankela->delete();

        alert()->html(
            'Dihapus!',
            'Pembagian Kelas untuk Siswa <strong>' . e($namaSiswa) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('pembagiankelas.index');
    }
}
