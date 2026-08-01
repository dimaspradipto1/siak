<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Guru;
use App\DataTables\MataPelajaranAktifDataTable;
use Illuminate\Http\Request;

class MataPelajaranAktifController extends Controller
{
    use \App\Traits\AuthorizeMasterData;

    public function index(MataPelajaranAktifDataTable $dataTable)
    {
        return $dataTable->render('pages.mata-pelajaran-aktif.index');
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::all();
        $semesters = Semester::all();
        $gurus = Guru::with('pegawai')->get();

        // Get unique master subjects to select from
        $masterMapels = MataPelajaran::whereNull('kelas_id')->get();
        if ($masterMapels->isEmpty()) {
            $masterMapels = MataPelajaran::all()->unique('nama_mata_pelajaran');
        }

        return view('pages.mata-pelajaran-aktif.create', compact('kelas', 'tahunAjarans', 'semesters', 'gurus', 'masterMapels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id'            => 'required|exists:kelas,id',
            'tahun_ajaran_id'     => 'required|exists:tahun_ajarans,id',
            'semester_id'         => 'required|exists:semesters,id',
            'master_mapel_id'     => 'required', // can be an ID or kode_mapel
            'guru_id'             => 'required|exists:gurus,id',
            'status'              => 'required|string|max:20',
            'hari_mengajar'       => 'required|string|max:20',
            'jam_mengajar'        => 'required|string|max:50',
        ]);

        // Find the master subject template
        $masterMapel = MataPelajaran::find($validated['master_mapel_id']);
        if (!$masterMapel) {
            $masterMapel = MataPelajaran::where('kode_mapel', $validated['master_mapel_id'])->first();
        }

        $namaMapel = $masterMapel ? $masterMapel->nama_mata_pelajaran : 'Mata Pelajaran';
        $kodeMapel = $masterMapel ? $masterMapel->kode_mapel : 'MP';
        $kkm = $masterMapel ? $masterMapel->kkm : 75;
        $tpOptimal = $masterMapel ? $masterMapel->tp_optimal : null;
        $tpPeningkatan = $masterMapel ? $masterMapel->tp_peningkatan : null;

        $mapel = MataPelajaran::create([
            'kelas_id'            => $validated['kelas_id'],
            'tahun_ajaran_id'     => $validated['tahun_ajaran_id'],
            'semester_id'         => $validated['semester_id'],
            'kode_mapel'          => $kodeMapel,
            'nama_mata_pelajaran' => $namaMapel,
            'kkm'                 => $kkm,
            'tp_optimal'          => $tpOptimal,
            'tp_peningkatan'      => $tpPeningkatan,
            'guru_id'             => $validated['guru_id'],
            'status'              => $validated['status'],
            'hari_mengajar'       => $validated['hari_mengajar'],
            'jam_mengajar'        => $validated['jam_mengajar'],
        ]);

        alert()->html(
            'Berhasil!',
            'Mata Pelajaran Aktif <strong>' . e($mapel->nama_mata_pelajaran) . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('matapelajaranaktif.index');
    }

    public function edit($id)
    {
        $matapelajaran = MataPelajaran::findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::all();
        $semesters = Semester::all();
        $gurus = Guru::with('pegawai')->get();

        $masterMapels = MataPelajaran::whereNull('kelas_id')->get();
        if ($masterMapels->isEmpty()) {
            $masterMapels = MataPelajaran::all()->unique('nama_mata_pelajaran');
        }

        return view('pages.mata-pelajaran-aktif.edit', compact('matapelajaran', 'kelas', 'tahunAjarans', 'semesters', 'gurus', 'masterMapels'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kelas_id'            => 'required|exists:kelas,id',
            'tahun_ajaran_id'     => 'required|exists:tahun_ajarans,id',
            'semester_id'         => 'required|exists:semesters,id',
            'master_mapel_id'     => 'required',
            'guru_id'             => 'required|exists:gurus,id',
            'status'              => 'required|string|max:20',
            'hari_mengajar'       => 'required|string|max:20',
            'jam_mengajar'        => 'required|string|max:50',
        ]);

        $mapel = MataPelajaran::findOrFail($id);

        $masterMapel = MataPelajaran::find($validated['master_mapel_id']);
        if (!$masterMapel) {
            $masterMapel = MataPelajaran::where('kode_mapel', $validated['master_mapel_id'])->first();
        }

        $namaMapel = $masterMapel ? $masterMapel->nama_mata_pelajaran : $mapel->nama_mata_pelajaran;
        $kodeMapel = $masterMapel ? $masterMapel->kode_mapel : $mapel->kode_mapel;
        $kkm = $masterMapel ? $masterMapel->kkm : $mapel->kkm;
        $tpOptimal = $masterMapel ? $masterMapel->tp_optimal : $mapel->tp_optimal;
        $tpPeningkatan = $masterMapel ? $masterMapel->tp_peningkatan : $mapel->tp_peningkatan;

        $mapel->update([
            'kelas_id'            => $validated['kelas_id'],
            'tahun_ajaran_id'     => $validated['tahun_ajaran_id'],
            'semester_id'         => $validated['semester_id'],
            'kode_mapel'          => $kodeMapel,
            'nama_mata_pelajaran' => $namaMapel,
            'kkm'                 => $kkm,
            'tp_optimal'          => $tpOptimal,
            'tp_peningkatan'      => $tpPeningkatan,
            'guru_id'             => $validated['guru_id'],
            'status'              => $validated['status'],
            'hari_mengajar'       => $validated['hari_mengajar'],
            'jam_mengajar'        => $validated['jam_mengajar'],
        ]);

        alert()->html(
            'Diperbarui!',
            'Mata Pelajaran Aktif <strong>' . e($mapel->nama_mata_pelajaran) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('matapelajaranaktif.index');
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $nama = $mapel->nama_mata_pelajaran;
        $mapel->delete();

        alert()->html(
            'Dihapus!',
            'Mata Pelajaran Aktif <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('matapelajaranaktif.index');
    }
}
