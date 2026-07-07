<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\PembagianKelas;
use App\Models\ProfilSekolah;
use App\Models\Kehadiran;
use App\Models\CatatanSiswa;
use App\Models\WaliKelas;
use App\Http\Requests\NilaiRequest;

use App\DataTables\NilaiDataTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Imports\NilaiImport;
use App\Exports\NilaiTemplateExport;

class NilaiController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;

    public function index(NilaiDataTable $dataTable)
    {
        if (auth()->check() && auth()->user()->roles === 'wali kelas') {
            return redirect()->route('nilai.rekap-raport');
        }
        return $dataTable->render('pages.nilai.index');
    }

    public function create()
    {
        $siswas = Siswa::query()->with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $mapels = MataPelajaran::query()->get();
        $semesters = Semester::query()->with('tahunAjaran')->get();
        $tahunAjarans = TahunAjaran::query()->get();
        return view('pages.nilai.create', compact('siswas', 'mapels', 'semesters', 'tahunAjarans'));
    }

    public function store(NilaiRequest $request)
    {
        $validated = $request->validated();
        Nilai::query()->create($validated);

        alert()->html(
            'Berhasil!',
            'Data nilai berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('nilai.index');
    }

    public function show(Nilai $nilai)
    {
        return redirect()->route('nilai.edit', $nilai);
    }

    public function edit(Nilai $nilai)
    {
        $siswas = Siswa::query()->with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $mapels = MataPelajaran::query()->get();
        $semesters = Semester::query()->with('tahunAjaran')->get();
        $tahunAjarans = TahunAjaran::query()->get();
        return view('pages.nilai.edit', compact('nilai', 'siswas', 'mapels', 'semesters', 'tahunAjarans'));
    }

    public function update(NilaiRequest $request, Nilai $nilai)
    {
        $validated = $request->validated();
        $nilai->update($validated);

        alert()->html(
            'Diperbarui!',
            'Data nilai berhasil diperbarui.',
            'success'
        );

        return redirect()->route('nilai.index');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        alert()->html(
            'Dihapus!',
            'Data nilai berhasil dihapus.',
            'success'
        );

        return redirect()->route('nilai.index');
    }

    /**
     * Helper to resolve filters with smart fallbacks to active school year and semester.
     */
    private function resolveFilters(Request $request)
    {
        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSem = $request->get('semester_id');
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mata_pelajaran_id');

        if (!$selectedTa) {
            $activeTa = TahunAjaran::query()->where('status', 'Aktif')->first() ?? TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }
        if (!$selectedSem && $selectedTa) {
            $activeSem = Semester::query()->where('tahun_ajaran_id', $selectedTa)->first();
            $selectedSem = $activeSem ? $activeSem->id : null;
        }

        return [$selectedTa, $selectedSem, $selectedKelas, $selectedMapel];
    }

    // ----------------------------------------------------
    // BULK GRADING: NILAI HARIAN
    // ----------------------------------------------------
    public function harian(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';
        
        list($selectedTa, $selectedSem, $selectedKelas, $selectedMapel) = $this->resolveFilters($request);

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->whereIn('id', $mapels->pluck('kelas_id'))->orderBy('nama_kelas', 'asc')->get();
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        }

        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel) {
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('semester_id', $selectedSem)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->first();
                
                $siswa->nilai_record = $nilaiRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.harian', compact('mapels', 'kelas', 'semesters', 'tahunAjarans', 'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'students'));
    }

    public function harianSave(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
        ]);

        $taId = $request->tahun_ajaran_id;
        $semId = $request->semester_id;
        $mapelId = $request->mata_pelajaran_id;
        $gradesInput = $request->nilai;

        foreach ($gradesInput as $siswaId => $data) {
            $lms = [];
            for ($lm = 1; $lm <= 5; $lm++) {
                $tps = [];
                for ($tp = 1; $tp <= 4; $tp++) {
                    $val = $data["lm{$lm}_tp{$tp}"];
                    if ($val !== '' && $val !== null) {
                        $tps[] = floatval($val);
                    }
                }
                $lms[$lm] = count($tps) > 0 ? array_sum($tps) / count($tps) : null;
            }

            $nilaiHarian = null;
            if ($lms[1] !== null && $lms[2] !== null && $lms[3] !== null && $lms[4] !== null && $lms[5] !== null) {
                $nilaiHarian = ($lms[1] + $lms[2] + $lms[3] + $lms[4] + $lms[5]) / 5;
            }

            $predikat = $nilaiHarian !== null ? Nilai::hitungPredikat($nilaiHarian) : null;

            Nilai::query()->updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mata_pelajaran_id' => $mapelId,
                    'semester_id' => $semId,
                    'tahun_ajaran_id' => $taId,
                ],
                [
                    'lm1_tp1' => $data['lm1_tp1'] !== '' ? $data['lm1_tp1'] : null,
                    'lm1_tp2' => $data['lm1_tp2'] !== '' ? $data['lm1_tp2'] : null,
                    'lm1_tp3' => $data['lm1_tp3'] !== '' ? $data['lm1_tp3'] : null,
                    'lm1_tp4' => $data['lm1_tp4'] !== '' ? $data['lm1_tp4'] : null,
                    'lm1' => $lms[1],

                    'lm2_tp1' => $data['lm2_tp1'] !== '' ? $data['lm2_tp1'] : null,
                    'lm2_tp2' => $data['lm2_tp2'] !== '' ? $data['lm2_tp2'] : null,
                    'lm2_tp3' => $data['lm2_tp3'] !== '' ? $data['lm2_tp3'] : null,
                    'lm2_tp4' => $data['lm2_tp4'] !== '' ? $data['lm2_tp4'] : null,
                    'lm2' => $lms[2],

                    'lm3_tp1' => $data['lm3_tp1'] !== '' ? $data['lm3_tp1'] : null,
                    'lm3_tp2' => $data['lm3_tp2'] !== '' ? $data['lm3_tp2'] : null,
                    'lm3_tp3' => $data['lm3_tp3'] !== '' ? $data['lm3_tp3'] : null,
                    'lm3_tp4' => $data['lm3_tp4'] !== '' ? $data['lm3_tp4'] : null,
                    'lm3' => $lms[3],

                    'lm4_tp1' => $data['lm4_tp1'] !== '' ? $data['lm4_tp1'] : null,
                    'lm4_tp2' => $data['lm4_tp2'] !== '' ? $data['lm4_tp2'] : null,
                    'lm4_tp3' => $data['lm4_tp3'] !== '' ? $data['lm4_tp3'] : null,
                    'lm4_tp4' => $data['lm4_tp4'] !== '' ? $data['lm4_tp4'] : null,
                    'lm4' => $lms[4],

                    'lm5_tp1' => $data['lm5_tp1'] !== '' ? $data['lm5_tp1'] : null,
                    'lm5_tp2' => $data['lm5_tp2'] !== '' ? $data['lm5_tp2'] : null,
                    'lm5_tp3' => $data['lm5_tp3'] !== '' ? $data['lm5_tp3'] : null,
                    'lm5_tp4' => $data['lm5_tp4'] !== '' ? $data['lm5_tp4'] : null,
                    'lm5' => $lms[5],

                    'nilai_harian' => $nilaiHarian,
                    'nilai' => $nilaiHarian, // fallback main column
                    'predikat' => $predikat,
                ]
            );
        }

        alert()->html('Berhasil!', 'Data Nilai Harian berhasil disimpan.', 'success');
        return back();
    }

    // ----------------------------------------------------
    // BULK GRADING: NILAI MID (UTS)
    // ----------------------------------------------------
    public function mid(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';
        
        list($selectedTa, $selectedSem, $selectedKelas, $selectedMapel) = $this->resolveFilters($request);

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->whereIn('id', $mapels->pluck('kelas_id'))->orderBy('nama_kelas', 'asc')->get();
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        }

        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel) {
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('semester_id', $selectedSem)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->first();
                
                $siswa->nilai_record = $nilaiRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.mid', compact('mapels', 'kelas', 'semesters', 'tahunAjarans', 'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'students'));
    }

    public function midSave(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
        ]);

        $taId = $request->tahun_ajaran_id;
        $semId = $request->semester_id;
        $mapelId = $request->mata_pelajaran_id;
        $gradesInput = $request->nilai;

        foreach ($gradesInput as $siswaId => $data) {
            $nilaiMid = $data['nilai_mid'] !== '' ? floatval($data['nilai_mid']) : null;
            $nilaiMidPlus = isset($data['nilai_mid_plus']) && $data['nilai_mid_plus'] !== '' ? floatval($data['nilai_mid_plus']) : null;

            Nilai::query()->updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mata_pelajaran_id' => $mapelId,
                    'semester_id' => $semId,
                    'tahun_ajaran_id' => $taId,
                ],
                [
                    'nilai_mid' => $nilaiMid,
                    'nilai_mid_plus' => $nilaiMidPlus,
                ]
            );
        }

        alert()->html('Berhasil!', 'Data Nilai MID berhasil disimpan.', 'success');
        return back();
    }

    // ----------------------------------------------------
    // BULK GRADING: NILAI PAS (UAS)
    // ----------------------------------------------------
    public function pas(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';
        
        list($selectedTa, $selectedSem, $selectedKelas, $selectedMapel) = $this->resolveFilters($request);

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->whereIn('id', $mapels->pluck('kelas_id'))->orderBy('nama_kelas', 'asc')->get();
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        }

        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel) {
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('semester_id', $selectedSem)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->first();
                
                $siswa->nilai_record = $nilaiRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.pas', compact('mapels', 'kelas', 'semesters', 'tahunAjarans', 'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'students'));
    }

    public function pasSave(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
        ]);

        $taId = $request->tahun_ajaran_id;
        $semId = $request->semester_id;
        $mapelId = $request->mata_pelajaran_id;
        $gradesInput = $request->nilai;

        foreach ($gradesInput as $siswaId => $data) {
            $nilaiPas = $data['nilai_pas'] !== '' ? floatval($data['nilai_pas']) : null;
            $nilaiPasPlus = isset($data['nilai_pas_plus']) && $data['nilai_pas_plus'] !== '' ? floatval($data['nilai_pas_plus']) : null;

            Nilai::query()->updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mata_pelajaran_id' => $mapelId,
                    'semester_id' => $semId,
                    'tahun_ajaran_id' => $taId,
                ],
                [
                    'nilai_pas' => $nilaiPas,
                    'nilai_pas_plus' => $nilaiPasPlus,
                ]
            );
        }

        alert()->html('Berhasil!', 'Data Nilai PAS berhasil disimpan.', 'success');
        return back();
    }

    // ----------------------------------------------------
    // BULK GRADING: NILAI RAPORT (2*Harian + UTS + UAS) / 4
    // ----------------------------------------------------
    public function raportInput(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';
        
        list($selectedTa, $selectedSem, $selectedKelas, $selectedMapel) = $this->resolveFilters($request);

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->whereIn('id', $mapels->pluck('kelas_id'))->orderBy('nama_kelas', 'asc')->get();
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        }

        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel) {
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('semester_id', $selectedSem)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->first();
                
                $siswa->nilai_record = $nilaiRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.raport_input', compact('mapels', 'kelas', 'semesters', 'tahunAjarans', 'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'students'));
    }

    public function raportInputSave(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
        ]);

        $taId = $request->tahun_ajaran_id;
        $semId = $request->semester_id;
        $mapelId = $request->mata_pelajaran_id;
        $gradesInput = $request->nilai;

        foreach ($gradesInput as $siswaId => $data) {
            $nilaiRaport = $data['nilai_raport'] !== '' ? round(floatval($data['nilai_raport'])) : null;
            $predikat = $nilaiRaport !== null ? Nilai::hitungPredikat($nilaiRaport) : null;

            Nilai::query()->updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mata_pelajaran_id' => $mapelId,
                    'semester_id' => $semId,
                    'tahun_ajaran_id' => $taId,
                ],
                [
                    'nilai_raport' => $nilaiRaport,
                    'nilai' => $nilaiRaport, // sync main fallback column
                    'predikat' => $predikat,
                ]
            );
        }

        alert()->html('Berhasil!', 'Data Nilai Raport berhasil disimpan.', 'success');
        return back();
    }

    // ----------------------------------------------------
    // REKAP: REKAP NILAI PER MATA PELAJARAN
    // ----------------------------------------------------
    public function rekapMapel(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';
        
        list($selectedTa, $selectedSem, $selectedKelas, $selectedMapel) = $this->resolveFilters($request);

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->whereIn('id', $mapels->pluck('kelas_id'))->orderBy('nama_kelas', 'asc')->get();
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->get();
            $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        }

        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        $students = [];
        $selectedMapelModel = null;
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel) {
            $selectedMapelModel = MataPelajaran::query()->find($selectedMapel);
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('semester_id', $selectedSem)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->first();
                
                $siswa->nilai_record = $nilaiRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.rekap_mapel', compact('mapels', 'kelas', 'semesters', 'tahunAjarans', 'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'students', 'selectedMapelModel'));
    }

    public function rekapRaport(Request $request)
    {
        $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::query()->get();

        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSemName = $request->get('semester_name');
        $selectedKelas = $request->get('kelas_id');

        if (!$selectedTa) {
            $activeTa = TahunAjaran::query()->where('status', 'Aktif')->first() ?? TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }
        if (!$selectedSemName) {
            $selectedSemName = 'Semester 1 (Ganjil)';
        }

        $semester = null;
        if ($selectedTa && $selectedSemName) {
            $semester = Semester::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('nama_semester', $selectedSemName)
                ->first();
        }
        $selectedSem = $semester ? $semester->id : null;

        $students = [];
        $classMapels = [];
        
        if ($selectedTa && $selectedSem && $selectedKelas) {
            // Get all mapels bound to this class in academic year
            $classMapels = MataPelajaran::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('semester_id', $selectedSem)
                ->orderBy('nama_mata_pelajaran', 'asc')
                ->get();

            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                $mapelGrades = [];
                $total = 0;
                $count = 0;
                
                foreach ($classMapels as $mp) {
                    $nilaiRecord = Nilai::query()->where('siswa_id', $siswa->id)
                        ->where('mata_pelajaran_id', $mp->id)
                        ->where('semester_id', $selectedSem)
                        ->where('tahun_ajaran_id', $selectedTa)
                        ->first();
                    
                    $grade = null;
                    if ($nilaiRecord) {
                        $grade = $nilaiRecord->nilai_raport !== null ? floatval($nilaiRecord->nilai_raport) : ($nilaiRecord->nilai !== null ? floatval($nilaiRecord->nilai) : null);
                    }
                    
                    $mapelGrades[$mp->id] = $grade;
                    if ($grade !== null) {
                        $total += floatval($grade);
                        $count++;
                    }
                }
                
                $siswa->grades = $mapelGrades;
                $siswa->average = $count > 0 ? $total / $count : null;
                $siswa->predikat = $siswa->average !== null ? Nilai::hitungPredikat($siswa->average) : '-';
                $students[] = $siswa;
            }
        }

        return view('pages.nilai.rekap_raport', compact('kelas', 'tahunAjarans', 'selectedTa', 'selectedSemName', 'selectedSem', 'selectedKelas', 'students', 'classMapels'));
    }

    public function cetakRaportList(Request $request)
    {
        $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::query()->get();

        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSemName = $request->get('semester_name');
        $selectedKelas = $request->get('kelas_id');

        if (!$selectedTa) {
            $activeTa = TahunAjaran::query()->where('status', 'Aktif')->first() ?? TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }
        if (!$selectedSemName) {
            $selectedSemName = 'Semester 1 (Ganjil)';
        }

        $semester = null;
        if ($selectedTa && $selectedSemName) {
            $semester = Semester::query()
                ->where('tahun_ajaran_id', $selectedTa)
                ->where('nama_semester', $selectedSemName)
                ->first();
        }
        $selectedSem = $semester ? $semester->id : null;

        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas) {
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $students = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();
        }

        return view('pages.nilai.cetak_raport_list', compact('kelas', 'tahunAjarans', 'selectedTa', 'selectedSemName', 'selectedSem', 'selectedKelas', 'students'));
    }

    public function cetakRaportPrint($siswa_id, $tahun_ajaran_id, $semester_id)
    {
        $siswa = Siswa::query()->findOrFail($siswa_id);
        $tahunAjaran = TahunAjaran::query()->findOrFail($tahun_ajaran_id);
        $semester = Semester::query()->findOrFail($semester_id);
        
        $pembagianKelas = PembagianKelas::query()
            ->where('siswa_id', $siswa_id)
            ->where('tahun_ajaran_id', $tahun_ajaran_id)
            ->first();
        $kelasId = $pembagianKelas ? $pembagianKelas->kelas_id : $siswa->kelas_id;
        $kelasModel = Kelas::query()->find($kelasId);

        $school = \App\Models\ProfilSekolah::query()->first();

        $classMapels = MataPelajaran::query()->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahun_ajaran_id)
            ->where('semester_id', $semester_id)
            ->orderBy('nama_mata_pelajaran', 'asc')
            ->get();

        $grades = [];
        foreach ($classMapels as $mp) {
            $nilaiRecord = Nilai::query()->where('siswa_id', $siswa_id)
                ->where('mata_pelajaran_id', $mp->id)
                ->where('semester_id', $semester_id)
                ->where('tahun_ajaran_id', $tahun_ajaran_id)
                ->first();
            $grades[$mp->id] = $nilaiRecord;
        }

        $attendance = [
            'Sakit' => \App\Models\Kehadiran::query()->where('siswa_id', $siswa_id)
                ->whereHas('jenisKehadiran', function($q) { $q->where('nama_kehadiran', 'Sakit'); })
                ->count(),
            'Izin' => \App\Models\Kehadiran::query()->where('siswa_id', $siswa_id)
                ->whereHas('jenisKehadiran', function($q) { $q->where('nama_kehadiran', 'Izin'); })
                ->count(),
            'Alpa' => \App\Models\Kehadiran::query()->where('siswa_id', $siswa_id)
                ->whereHas('jenisKehadiran', function($q) { $q->where('nama_kehadiran', 'Alpa')->orWhere('nama_kehadiran', 'Tanpa Keterangan'); })
                ->count(),
        ];

        $catatan = \App\Models\CatatanSiswa::query()->where('siswa_id', $siswa_id)
            ->where('semester_id', $semester_id)
            ->where('tahun_ajaran_id', $tahun_ajaran_id)
            ->first();

        $waliKelas = \App\Models\WaliKelas::query()->where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahun_ajaran_id)
            ->first();

        return view('pages.nilai.cetak_raport_print', compact('siswa', 'tahunAjaran', 'semester', 'kelasModel', 'school', 'classMapels', 'grades', 'attendance', 'catatan', 'waliKelas'));
    }
}
