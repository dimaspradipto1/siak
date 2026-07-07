<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Kelas;
use App\Models\Ekstrakurikuler;
use App\Http\Requests\SiswaRequest;

use App\DataTables\SiswaDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;

class SiswaController extends Controller
{
    use \App\Traits\AuthorizeMasterData;
    public function index(SiswaDataTable $dataTable)
    {
        return $dataTable->render('pages.siswa.index');
    }

    public function create()
    {
        $orangTuas = OrangTua::all();
        $kelas = Kelas::all();
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('pages.siswa.create', compact('orangTuas', 'kelas', 'ekstrakurikulers'));
    }

    public function store(SiswaRequest $request)
    {
        $validated = $request->validated();
        $siswa = Siswa::create($validated);

        alert()->html(
            'Berhasil!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil ditambahkan.',
            'success'
        );

        return redirect()->route('siswa.index');
    }

    public function show(Siswa $siswa)
    {
        return redirect()->route('siswa.edit', $siswa);
    }

    public function edit(Siswa $siswa)
    {
        $orangTuas = OrangTua::all();
        $kelas = Kelas::all();
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('pages.siswa.edit', compact('siswa', 'orangTuas', 'kelas', 'ekstrakurikulers'));
    }

    public function update(SiswaRequest $request, Siswa $siswa)
    {
        $validated = $request->validated();
        $siswa->update($validated);

        alert()->html(
            'Diperbarui!',
            'Data Siswa <strong>' . e($siswa->nama_siswa) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('siswa.index');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaExport, 'Data_Siswa_'.date('Ymd').'.xlsx');
    }

    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SiswaImport, $request->file('file'));

        alert()->success('Berhasil!', 'Data Siswa berhasil diimport.');
        return redirect()->route('siswa.index');
    }

    public function template()
    {
        $headers = [['NISN', 'NIS', 'Nama Siswa', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat', 'Nama Kelas', 'Nama Ibu Kandung']];
        $export = new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        };
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Template_Import_Siswa.xlsx');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama_siswa;
        $siswa->delete();

        alert()->html(
            'Dihapus!',
            'Data Siswa <strong>' . e($nama) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('siswa.index');
    }

    private function resolveSiswaAndOrangTua($user)
    {
        $siswa = null;
        $orangTua = null;

        if ($user->roles === 'siswa') {
            $siswa = Siswa::where('user_id', $user->id)->first();
            if (!$siswa) {
                $siswa = Siswa::where('nama_siswa', 'like', '%' . $user->name . '%')->first();
                if (!$siswa) {
                    $siswa = Siswa::whereNull('user_id')->first();
                }
                if ($siswa) {
                    $siswa->update(['user_id' => $user->id]);
                }
            }
            if ($siswa) {
                $orangTua = $siswa->orangTua;
            }
        } elseif ($user->roles === 'orang tua') {
            $orangTua = OrangTua::where('user_id', $user->id)->first();
            if (!$orangTua) {
                $orangTua = OrangTua::where('nama_ayah', 'like', '%' . $user->name . '%')
                    ->orWhere('nama_ibu', 'like', '%' . $user->name . '%')
                    ->first();
                if (!$orangTua) {
                    $orangTua = OrangTua::whereNull('user_id')->first();
                }
                if ($orangTua) {
                    $orangTua->update(['user_id' => $user->id]);
                }
            }
            if ($orangTua) {
                $siswa = Siswa::where('orang_tua_id', $orangTua->id)->first();
            }
        }

        // Auto-create User account for Student if not linked
        if ($siswa && !$siswa->user_id) {
            $username = preg_replace('/[^A-Za-z0-9]/', '', strtolower($siswa->nisn));
            $studentUser = User::where('username', $username)->first();
            if (!$studentUser) {
                $studentUser = User::create([
                    'name' => $siswa->nama_siswa,
                    'username' => $username,
                    'email' => $username . '@gmail.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'roles' => 'siswa',
                    'is_active' => true,
                ]);
            }
            $siswa->update(['user_id' => $studentUser->id]);
            $siswa->load('user');
        }

        // Auto-create User account for Parent if not linked
        if ($orangTua && !$orangTua->user_id) {
            $username = 'ortu_' . ($siswa ? $siswa->nisn : rand(10000000, 99999999));
            $parentUser = User::where('username', $username)->first();
            if (!$parentUser) {
                $parentUser = User::create([
                    'name' => $orangTua->nama_ayah,
                    'username' => $username,
                    'email' => $username . '@gmail.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'roles' => 'orang tua',
                    'is_active' => true,
                ]);
            }
            $orangTua->update(['user_id' => $parentUser->id]);
            $orangTua->load('user');
        }

        return [$siswa, $orangTua];
    }

    public function profile()
    {
        $user = auth()->user();
        list($siswa, $orangTua) = $this->resolveSiswaAndOrangTua($user);

        if (!$siswa) {
            alert()->error('Error', 'Data profil siswa tidak ditemukan.');
            return redirect()->route('dashboard');
        }

        return view('pages.siswa.profile', compact('siswa', 'orangTua'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        list($siswa, $orangTua) = $this->resolveSiswaAndOrangTua($user);

        if (!$siswa) {
            alert()->error('Error', 'Data profil siswa tidak ditemukan.');
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            // Data Pribadi
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'nomor_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tgl_masuk' => 'nullable|date',
            'email_siswa' => 'required|email|unique:users,email,' . ($siswa->user_id ?? 0),

            // Data Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nomor_wa_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'nomor_wa_ibu' => 'nullable|string|max:20',
            'alamat_ortu' => 'nullable|string',
            'email_ortu' => 'nullable|email',
        ]);

        // 1. Update Student model
        $siswa->update([
            'nama_siswa' => $validated['nama_siswa'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tgl_lahir' => $validated['tgl_lahir'],
            'agama' => $validated['agama'],
            'nomor_wa' => $validated['nomor_wa'],
            'alamat' => $validated['alamat'],
            'tgl_masuk' => $validated['tgl_masuk'],
        ]);

        // Update Student User Email
        if ($siswa->user) {
            $siswa->user->update(['email' => $validated['email_siswa']]);
        }

        // 2. Update parent
        if ($orangTua) {
            $orangTua->update([
                'nama_ayah' => $validated['nama_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'nomor_wa' => $validated['nomor_wa_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'nomor_wa_ibu' => $validated['nomor_wa_ibu'],
                'alamat' => $validated['alamat_ortu'],
                'email' => $validated['email_ortu'],
            ]);
            // If parent has user record, update email
            if ($orangTua->user) {
                $orangTua->user->update(['email' => $validated['email_ortu']]);
            }
        }

        alert()->success('Berhasil!', 'Data profil berhasil diperbarui.')->html();
        return redirect()->back();
    }
}
