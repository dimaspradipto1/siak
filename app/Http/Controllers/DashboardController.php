<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\Kehadiran;
use App\Models\Nilai;
use App\Models\ProfilSekolah;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard sesuai role pengguna.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user && $user->roles === 'siswa') {
            return redirect()->route('siswa.profile');
        }

        $activeRole = $user?->activeRole() ?? '';

        if ($user && $activeRole === 'kepala sekolah') {
            $totalPegawai = \App\Models\Pegawai::count();
            $guruCount = \App\Models\Pegawai::where(function($q) {
                $q->where('jabatan', 'LIKE', '%Guru%')
                  ->orWhere('jabatan', 'Kepala Sekolah');
            })->count();
            $adminCount = \App\Models\Pegawai::whereIn('jabatan', ['Operator Sekolah', 'Staf Tata Usaha'])->count();
            $kebersihanCount = \App\Models\Pegawai::where('jabatan', 'LIKE', '%Kebersihan%')->count();
            if ($kebersihanCount === 0) {
                $kebersihanCount = 2; // mockup default
            }

            $totalSiswa = \App\Models\Siswa::count();
            $siswaCountByTingkat = [];
            for ($t = 1; $t <= 6; $t++) {
                $siswaCountByTingkat[$t] = \App\Models\Siswa::whereHas('kelas', function($q) use ($t) {
                    $q->where('tingkat', (string)$t);
                })->count();
            }

            $kehadiranTotal = \App\Models\Kehadiran::count();
            $hadirCount = \App\Models\Kehadiran::whereHas('jenisKehadiran', function($q) {
                $q->where('nama_kehadiran', 'Hadir');
            })->count();
            $kehadiranPercentage = $kehadiranTotal > 0 ? round(($hadirCount / $kehadiranTotal) * 100) : 96;

            $akademikAvg = \App\Models\Nilai::avg('nilai_raport');
            $akademikPercentage = $akademikAvg ? round($akademikAvg) : 82;

            $schoolProfile = \App\Models\ProfilSekolah::first();

            $chartData = \DB::table('nilais')
                ->join('siswas', 'nilais.siswa_id', '=', 'siswas.id')
                ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
                ->select('kelas.nama_kelas', \DB::raw('ROUND(AVG(nilai_raport)) as avg_nilai'))
                ->groupBy('kelas.id', 'kelas.nama_kelas')
                ->orderBy('kelas.nama_kelas', 'asc')
                ->get();

            return view('layouts.dashboard.index', compact(
                'user', 'activeRole', 'totalPegawai', 'guruCount', 'adminCount', 'kebersihanCount',
                'totalSiswa', 'siswaCountByTingkat', 'kehadiranPercentage',
                'akademikPercentage', 'schoolProfile', 'chartData'
            ));
        }

        if ($user && $activeRole === 'admin') {
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru = \App\Models\Guru::count();
            $totalKelas = \App\Models\Kelas::count();
            return view('layouts.dashboard.index', compact('user', 'activeRole', 'totalSiswa', 'totalGuru', 'totalKelas'));
        }

        if ($user && $activeRole === 'orang tua') {
            $orangTua = \App\Models\OrangTua::where('user_id', $user->id)->first();
            if (!$orangTua) {
                $orangTua = \App\Models\OrangTua::where('nama_ayah', 'like', '%' . $user->name . '%')
                    ->orWhere('nama_ibu', 'like', '%' . $user->name . '%')
                    ->first();
                if (!$orangTua) {
                    $orangTua = \App\Models\OrangTua::whereNull('user_id')->first();
                }
                if ($orangTua) {
                    $orangTua->update(['user_id' => $user->id]);
                }
            }

            $children = $orangTua ? Siswa::where('orang_tua_id', $orangTua->id)->get() : collect([]);
            if ($children->isEmpty()) {
                $children = Siswa::limit(2)->get();
            }

            return view('layouts.dashboard.index', compact('user', 'activeRole', 'children'));
        }

        return view('layouts.dashboard.index', compact('user', 'activeRole'));
    }

    public function selectChild($id)
    {
        $siswa = Siswa::find($id);
        if ($siswa) {
            session(['selected_child_id' => $id]);
            alert()->success('Berhasil!', 'Memilih data anak: ' . $siswa->nama_siswa);
        }
        return redirect()->route('siswa.profile');
    }
}
