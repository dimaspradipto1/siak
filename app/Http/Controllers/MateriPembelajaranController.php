<?php

namespace App\Http\Controllers;

use App\Models\MateriPembelajaran;
use Illuminate\Http\Request;

use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Http\Requests\MateriPembelajaranRequest;
use App\DataTables\MateriPembelajaranDataTable;

class MateriPembelajaranController extends Controller
{
    use \App\Traits\AuthorizeTransactionData;

    /**
     * Display a listing of the resource.
     */
    public function index(MateriPembelajaranDataTable $dataTable)
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::all();
        $semesters = Semester::all();
        $matapelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return $dataTable->render('pages.materipembelajaran.index', compact('kelas', 'tahunAjarans', 'semesters', 'matapelajarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::all();
        $semesters = Semester::all();
        $matapelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return view('pages.materipembelajaran.create', compact('kelas', 'tahunAjarans', 'semesters', 'matapelajarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MateriPembelajaranRequest $request)
    {
        $validated = $request->validated();
        $validated['diupload_oleh'] = auth()->id();

        $semester = Semester::query()
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('nama_semester', $request->semester_name)
            ->first();
        $validated['semester_id'] = $semester ? $semester->id : null;
        unset($validated['semester_name']);

        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads/materi'))) {
                mkdir(public_path('uploads/materi'), 0755, true);
            }
            $file->move(public_path('uploads/materi'), $filename);
            $validated['file_materi'] = 'uploads/materi/' . $filename;

            // Get size
            $sizeInBytes = filesize(public_path($validated['file_materi']));
            if ($sizeInBytes >= 1048576) {
                $validated['file_size'] = number_format($sizeInBytes / 1048576, 2) . ' MB';
            } elseif ($sizeInBytes >= 1024) {
                $validated['file_size'] = number_format($sizeInBytes / 1024, 2) . ' KB';
            } else {
                $validated['file_size'] = $sizeInBytes . ' Bytes';
            }
        }

        $materi = MateriPembelajaran::create($validated);

        alert()->html(
            'Berhasil!',
            'Materi Pembelajaran <strong>' . e($materi->judul_materi) . '</strong> berhasil diunggah.',
            'success'
        );

        return redirect()->route('materipembelajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MateriPembelajaran $materipembelajaran)
    {
        return redirect()->route('materipembelajaran.download', $materipembelajaran->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MateriPembelajaran $materipembelajaran)
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $tahunAjarans = TahunAjaran::all();
        $semesters = Semester::all();
        $matapelajarans = MataPelajaran::orderBy('nama_mata_pelajaran', 'asc')->get();
        return view('pages.materipembelajaran.edit', compact('materipembelajaran', 'kelas', 'tahunAjarans', 'semesters', 'matapelajarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriPembelajaranRequest $request, MateriPembelajaran $materipembelajaran)
    {
        $validated = $request->validated();

        $semester = Semester::query()
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('nama_semester', $request->semester_name)
            ->first();
        $validated['semester_id'] = $semester ? $semester->id : null;
        unset($validated['semester_name']);

        if ($request->hasFile('file_materi')) {
            // Delete old file if exists
            if ($materipembelajaran->file_materi && file_exists(public_path($materipembelajaran->file_materi))) {
                @unlink(public_path($materipembelajaran->file_materi));
            }

            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!file_exists(public_path('uploads/materi'))) {
                mkdir(public_path('uploads/materi'), 0755, true);
            }
            $file->move(public_path('uploads/materi'), $filename);
            $validated['file_materi'] = 'uploads/materi/' . $filename;

            // Get size
            $sizeInBytes = filesize(public_path($validated['file_materi']));
            if ($sizeInBytes >= 1048576) {
                $validated['file_size'] = number_format($sizeInBytes / 1048576, 2) . ' MB';
            } elseif ($sizeInBytes >= 1024) {
                $validated['file_size'] = number_format($sizeInBytes / 1024, 2) . ' KB';
            } else {
                $validated['file_size'] = $sizeInBytes . ' Bytes';
            }
        }

        $materipembelajaran->update($validated);

        alert()->html(
            'Diperbarui!',
            'Materi Pembelajaran <strong>' . e($materipembelajaran->judul_materi) . '</strong> berhasil diperbarui.',
            'success'
        );

        return redirect()->route('materipembelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MateriPembelajaran $materipembelajaran)
    {
        $judul = $materipembelajaran->judul_materi;

        if ($materipembelajaran->file_materi && file_exists(public_path($materipembelajaran->file_materi))) {
            @unlink(public_path($materipembelajaran->file_materi));
        }

        $materipembelajaran->delete();

        alert()->html(
            'Dihapus!',
            'Materi Pembelajaran <strong>' . e($judul) . '</strong> berhasil dihapus.',
            'success'
        );

        return redirect()->route('materipembelajaran.index');
    }

    /**
     * Download the uploaded file.
     */
    public function download($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);
        $path = public_path($materi->file_materi);
        if (file_exists($path)) {
            return response()->download($path);
        }

        alert()->html(
            'Error!',
            'File materi tidak ditemukan di server.',
            'error'
        );
        return redirect()->back();
    }
}
