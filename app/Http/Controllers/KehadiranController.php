<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\JenisKehadiran;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\JenisCatatan;
use App\Models\CatatanSiswa;
use App\Models\PembagianKelas;
use App\Models\Guru;
use App\Models\ProfilSekolah;
use App\Models\WaliKelas;
use App\Http\Requests\KehadiranRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\DataTables\KehadiranDataTable;

class KehadiranController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user && $user->roles === 'wali kelas') {
            return redirect()->route('kehadiran.rekap');
        }
        $isGuru = $user->roles === 'guru';

        // 1. Resolve filters
        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSem = $request->get('semester_id');
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mata_pelajaran_id');
        $selectedBulan = $request->get('bulan');

        // Fallback for Tahun Ajaran
        if (!$selectedTa) {
            $activeTa = TahunAjaran::query()->where('status', 'Aktif')->first() ?? TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }

        // Fallback for Semester
        if (!$selectedSem && $selectedTa) {
            $activeSem = Semester::query()->where('tahun_ajaran_id', $selectedTa)->first();
            $selectedSem = $activeSem ? $activeSem->id : null;
        }

        // Fallback for Bulan
        if (!$selectedBulan) {
            $selectedBulan = date('n'); // default to current month number (1-12)
        }

        // 2. Fetch lists
        $tahunAjarans = TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : Semester::query()->get();

        // 3. Fetch Mapels and Kelas
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

        // 4. Resolve Calendar Year
        $selectedYear = date('Y');
        $tahunAjaran = TahunAjaran::find($selectedTa);
        if ($tahunAjaran) {
            if (in_array($selectedBulan, [7, 8, 9, 10, 11, 12])) {
                $selectedYear = $tahunAjaran->tahun_mulai;
            } else {
                $selectedYear = $tahunAjaran->tahun_selesai;
            }
        }

        // 5. Fetch students and attendance dates if all filters are set
        $students = [];
        $dates = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel && $selectedBulan) {
            // Find student IDs in this class & year
            $siswaIds = PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            // Get all dates in the selected month & year
            $daysInMonth = \Carbon\Carbon::create($selectedYear, $selectedBulan, 1)->daysInMonth;
            $dates = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dates[] = sprintf('%04d-%02d-%02d', $selectedYear, $selectedBulan, $day);
            }

            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                // Fetch all attendance records for this student on this subject in this month
                $attendanceRecords = Kehadiran::with('jenisKehadiran')
                    ->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->whereMonth('tanggal', $selectedBulan)
                    ->whereYear('tanggal', $selectedYear)
                    ->get();
                
                // Map attendance by date string 'Y-m-d' -> code
                $attendanceMap = [];
                foreach ($attendanceRecords as $rec) {
                    $attendanceMap[$rec->tanggal] = $rec->jenisKehadiran->kode_kehadiran ?? '';
                }

                $siswa->attendance_map = $attendanceMap;
                $students[] = $siswa;
            }
        }

        // Selected model details for rendering/print headings
        $selectedMapelModel = MataPelajaran::find($selectedMapel);
        $selectedKelasModel = Kelas::find($selectedKelas);

        return view('pages.kehadiran.index', compact(
            'mapels', 'kelas', 'semesters', 'tahunAjarans',
            'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'selectedBulan',
            'students', 'dates', 'selectedMapelModel', 'selectedKelasModel'
        ));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';

        // 1. Resolve filters
        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSem = $request->get('semester_id');
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mata_pelajaran_id');
        $selectedTanggal = $request->get('tanggal', date('Y-m-d'));

        // Fallback for Tahun Ajaran
        if (!$selectedTa) {
            $activeTa = \App\Models\TahunAjaran::query()->where('status', 'Aktif')->first() ?? \App\Models\TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }

        // Fallback for Semester
        if (!$selectedSem && $selectedTa) {
            $activeSem = \App\Models\Semester::query()->where('tahun_ajaran_id', $selectedTa)->first();
            $selectedSem = $activeSem ? $activeSem->id : null;
        }

        // 2. Fetch Tahun Ajaran and Semester lists
        $tahunAjarans = \App\Models\TahunAjaran::query()->get();
        $semesters = $selectedTa
            ? \App\Models\Semester::query()->where('tahun_ajaran_id', $selectedTa)->get()
            : \App\Models\Semester::query()->get();

        // 3. Fetch Mapels and Kelas
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

        $jenisKehadirans = JenisKehadiran::all();
        $jenisCatatans = \App\Models\JenisCatatan::all();

        // 4. Fetch students and their current attendance / notes if all filters are set
        $students = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedMapel && $selectedTanggal) {
            $siswaIds = \App\Models\PembagianKelas::query()->where('kelas_id', $selectedKelas)
                ->where('tahun_ajaran_id', $selectedTa)
                ->pluck('siswa_id');
            
            $studentsList = Siswa::query()->whereIn('id', $siswaIds)->orderBy('nama_siswa', 'asc')->get();

            foreach ($studentsList as $siswa) {
                // Fetch attendance
                $kehadiranRecord = Kehadiran::query()->where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $selectedMapel)
                    ->where('tanggal', $selectedTanggal)
                    ->first();
                
                // Fetch student note (CatatanSiswa)
                $mapel = MataPelajaran::find($selectedMapel);
                $guruId = $mapel ? $mapel->guru_id : null;
                if (!$guruId && $isGuru) {
                    $guruId = $user->pegawai?->guru?->id;
                }

                $catatanRecord = \App\Models\CatatanSiswa::query()->where('siswa_id', $siswa->id)
                    ->where('tahun_ajaran_id', $selectedTa)
                    ->where('semester_id', $selectedSem)
                    ->where('tanggal', $selectedTanggal)
                    ->when($guruId, function($q) use ($guruId) {
                        return $q->where('guru_id', $guruId);
                    })
                    ->first();

                $siswa->kehadiran_record = $kehadiranRecord;
                $siswa->catatan_record = $catatanRecord;
                $students[] = $siswa;
            }
        }

        return view('pages.kehadiran.create', compact(
            'mapels', 'kelas', 'semesters', 'tahunAjarans', 
            'selectedTa', 'selectedSem', 'selectedKelas', 'selectedMapel', 'selectedTanggal',
            'students', 'jenisKehadirans', 'jenisCatatans'
        ));
    }

    public function getKelasDanMapel(Request $request)
    {
        $taId = $request->get('tahun_ajaran_id');
        $semId = $request->get('semester_id');
        $user = auth()->user();
        $isGuru = $user->roles === 'guru';

        if ($isGuru) {
            $guru = $user->pegawai?->guru;
            $guruId = $guru ? $guru->id : 0;
            $mapels = MataPelajaran::query()->where('guru_id', $guruId)
                ->where('tahun_ajaran_id', $taId)
                ->where('semester_id', $semId)
                ->get(['id', 'nama_mata_pelajaran']);
            
            $kelas = Kelas::query()
                ->whereIn('id', MataPelajaran::query()->where('guru_id', $guruId)
                    ->where('tahun_ajaran_id', $taId)
                    ->where('semester_id', $semId)
                    ->pluck('kelas_id')
                )
                ->orderBy('nama_kelas', 'asc')
                ->get(['id', 'nama_kelas']);
        } else {
            $mapels = MataPelajaran::query()
                ->where('tahun_ajaran_id', $taId)
                ->where('semester_id', $semId)
                ->get(['id', 'nama_mata_pelajaran']);
            
            $kelas = Kelas::query()
                ->orderBy('nama_kelas', 'asc')
                ->get(['id', 'nama_kelas']);
        }

        return response()->json([
            'kelas' => $kelas,
            'mapels' => $mapels,
        ]);
    }

    public function bulkSave(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tanggal' => 'required|date',
            'kehadiran' => 'required|array',
            'jenis_catatan_id' => 'nullable|array',
            'keterangan' => 'nullable|array',
        ]);

        $taId = $request->tahun_ajaran_id;
        $semId = $request->semester_id;
        $mapelId = $request->mata_pelajaran_id;
        $tanggal = $request->tanggal;

        $kehadiranInput = $request->kehadiran;
        $jenisCatatanInput = $request->jenis_catatan_id ?? [];
        $keteranganInput = $request->keterangan ?? [];

        // Fetch subject's teacher to associate with student notes
        $mapel = MataPelajaran::find($mapelId);
        $guruId = $mapel ? $mapel->guru_id : null;
        if (!$guruId) {
            $user = auth()->user();
            if ($user->roles === 'guru') {
                $guruId = $user->pegawai?->guru?->id;
            }
        }

        if (!$guruId) {
            // Find first guru in DB as a safe fallback
            $fallbackGuru = \App\Models\Guru::first();
            $guruId = $fallbackGuru ? $fallbackGuru->id : null;
        }

        foreach ($kehadiranInput as $siswaId => $jenisKehadiranId) {
            if ($jenisKehadiranId) {
                $keterangan = $keteranganInput[$siswaId] ?? null;

                // Save or update attendance
                Kehadiran::query()->updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mata_pelajaran_id' => $mapelId,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'jenis_kehadiran_id' => $jenisKehadiranId,
                        'keterangan' => $keterangan,
                    ]
                );

                // Save or update student notes (CatatanSiswa) if a type is selected
                $jenisCatatanId = $jenisCatatanInput[$siswaId] ?? null;
                if ($jenisCatatanId) {
                    \App\Models\CatatanSiswa::query()->updateOrCreate(
                        [
                            'siswa_id' => $siswaId,
                            'tahun_ajaran_id' => $taId,
                            'semester_id' => $semId,
                            'tanggal' => $tanggal,
                            'guru_id' => $guruId,
                        ],
                        [
                            'jenis_catatan_id' => $jenisCatatanId,
                            'isi_catatan' => $keterangan,
                            'status' => 'Aktif',
                        ]
                    );
                }
            }
        }

        alert()->success(
            'Berhasil!',
            'Data kehadiran berhasil disimpan.'
        );

        return redirect()->route('kehadiran.create', [
            'tahun_ajaran_id' => $taId,
            'semester_id' => $semId,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $mapelId,
            'tanggal' => $tanggal,
        ]);
    }

    public function store(KehadiranRequest $request)
    {
        $validated = $request->validated();
        Kehadiran::create($validated);

        alert()->success(
            'Berhasil!',
            'Data kehadiran berhasil ditambahkan.'
        );

        return redirect()->route('kehadiran.index');
    }

    public function show(Kehadiran $kehadiran)
    {
        return redirect()->route('kehadiran.edit', $kehadiran);
    }

    public function edit(Kehadiran $kehadiran)
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $mapels = MataPelajaran::all();
        $jenisKehadirans = JenisKehadiran::all();
        return view('pages.kehadiran.edit', compact('kehadiran', 'siswas', 'mapels', 'jenisKehadirans'));
    }

    public function update(KehadiranRequest $request, Kehadiran $kehadiran)
    {
        $validated = $request->validated();
        $kehadiran->update($validated);

        alert()->success(
            'Diperbarui!',
            'Data kehadiran berhasil diperbarui.'
        );

        return redirect()->route('kehadiran.index');
    }

    public function destroy(Kehadiran $kehadiran)
    {
        $kehadiran->delete();

        alert()->success(
            'Dihapus!',
            'Data kehadiran berhasil dihapus.'
        );

        return redirect()->route('kehadiran.index');
    }

    public function rekapKehadiran(Request $request)
    {
        $kelas = Kelas::query()->orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::query()->get();
        $jenisKehadirans = JenisKehadiran::all();

        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSemName = $request->get('semester_name');
        $selectedKelas = $request->get('kelas_id');
        $selectedJenisKehadiran = $request->get('jenis_kehadiran_id');

        if (!$selectedTa) {
            $activeTa = TahunAjaran::query()->where('status', 'Aktif')->first() ?? TahunAjaran::query()->first();
            $selectedTa = $activeTa ? $activeTa->id : null;
        }
        if (!$selectedSemName) {
            $selectedSemName = 'Semester 1 (Ganjil)';
        }
        if (!$selectedJenisKehadiran) {
            $selectedJenisKehadiran = $jenisKehadirans->first()?->id;
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
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedJenisKehadiran) {
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
                $counts = [];
                foreach ($classMapels as $mp) {
                    $counts[$mp->id] = Kehadiran::query()->where('siswa_id', $siswa->id)
                        ->where('mata_pelajaran_id', $mp->id)
                        ->where('jenis_kehadiran_id', $selectedJenisKehadiran)
                        ->count();
                }
                $siswa->attendance_counts = $counts;
                $students[] = $siswa;
            }
        }

        $selectedJenisModel = JenisKehadiran::find($selectedJenisKehadiran);

        return view('pages.kehadiran.rekap', compact(
            'kelas', 'tahunAjarans', 'jenisKehadirans',
            'selectedTa', 'selectedSemName', 'selectedSem', 'selectedKelas', 'selectedJenisKehadiran',
            'students', 'classMapels', 'selectedJenisModel'
        ));
    }

    public function rekapKehadiranPrint(Request $request)
    {
        $selectedTa = $request->get('tahun_ajaran_id');
        $selectedSemName = $request->get('semester_name');
        $selectedKelas = $request->get('kelas_id');
        $selectedJenisKehadiran = $request->get('jenis_kehadiran_id');

        $tahunAjaran = TahunAjaran::find($selectedTa);
        
        $semester = Semester::query()
            ->where('tahun_ajaran_id', $selectedTa)
            ->where('nama_semester', $selectedSemName)
            ->first();
        $selectedSem = $semester ? $semester->id : null;

        $kelasModel = Kelas::find($selectedKelas);
        $jenisModel = JenisKehadiran::find($selectedJenisKehadiran);
        $school = \App\Models\ProfilSekolah::query()->first();

        $students = [];
        $classMapels = [];
        if ($selectedTa && $selectedSem && $selectedKelas && $selectedJenisKehadiran) {
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
                $counts = [];
                foreach ($classMapels as $mp) {
                    $counts[$mp->id] = Kehadiran::query()->where('siswa_id', $siswa->id)
                        ->where('mata_pelajaran_id', $mp->id)
                        ->where('jenis_kehadiran_id', $selectedJenisKehadiran)
                        ->count();
                }
                $siswa->attendance_counts = $counts;
                $students[] = $siswa;
            }
        }

        $waliKelas = \App\Models\WaliKelas::query()->where('kelas_id', $selectedKelas)
            ->where('tahun_ajaran_id', $selectedTa)
            ->first();

        return view('pages.kehadiran.rekap_print', compact(
            'tahunAjaran', 'semester', 'kelasModel', 'jenisModel', 'school',
            'students', 'classMapels', 'waliKelas', 'selectedSemName'
        ));
    }
}
