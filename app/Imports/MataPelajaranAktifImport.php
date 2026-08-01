<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MataPelajaranAktifImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        if (empty($row['kelas']) || empty($row['nama_mata_pelajaran']) || empty($row['nama_guru'])) {
            return null;
        }

        $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();
        if (!$kelas) {
            return null;
        }

        $tahunAjaran = null;
        if (!empty($row['tahun_ajaran'])) {
            $taParts = explode('/', $row['tahun_ajaran']);
            if (count($taParts) === 2) {
                $tahunAjaran = TahunAjaran::where('tahun_mulai', trim($taParts[0]))
                    ->where('tahun_selesai', trim($taParts[1]))
                    ->first();
            }
        }
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::where('status', 'Aktif')->first() ?? TahunAjaran::first();
        }

        $semester = null;
        if ($tahunAjaran && !empty($row['semester'])) {
            $semester = Semester::where('nama_semester', 'like', '%' . $row['semester'] . '%')
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->first();
        }
        if (!$semester && $tahunAjaran) {
            $semester = Semester::where('tahun_ajaran_id', $tahunAjaran->id)->first();
        }

        $guru = Guru::whereHas('pegawai', function ($q) use ($row) {
            $q->where('nama_pegawai', 'like', '%' . $row['nama_guru'] . '%');
        })->first();
        if (!$guru) {
            return null;
        }

        // Find template or create fallback values
        $template = MataPelajaran::whereNull('kelas_id')
            ->where('nama_mata_pelajaran', $row['nama_mata_pelajaran'])
            ->first();
        if (!$template) {
            $template = MataPelajaran::where('nama_mata_pelajaran', 'like', '%' . $row['nama_mata_pelajaran'] . '%')->first();
        }

        $kodeMapel = $template ? $template->kode_mapel : ('MP' . rand(100, 999));
        $kkm = $template ? $template->kkm : 75;
        $tpOptimal = $template ? $template->tp_optimal : null;
        $tpPeningkatan = $template ? $template->tp_peningkatan : null;

        return MataPelajaran::updateOrCreate(
            [
                'kelas_id'        => $kelas->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
                'semester_id'     => $semester?->id,
                'kode_mapel'      => $kodeMapel,
            ],
            [
                'nama_mata_pelajaran' => $row['nama_mata_pelajaran'],
                'kkm'                 => $kkm,
                'tp_optimal'          => $tpOptimal,
                'tp_peningkatan'      => $tpPeningkatan,
                'guru_id'             => $guru->id,
                'status'              => $row['status'] ?? 'Aktif',
                'hari_mengajar'       => $row['hari_mengajar'] ?? '',
                'jam_mengajar'        => $row['jam_mengajar'] ?? '',
            ]
        );
    }

    public function rules(): array
    {
        return [
            'kelas'               => 'required',
            'nama_mata_pelajaran' => 'required',
            'nama_guru'           => 'required',
        ];
    }
}
