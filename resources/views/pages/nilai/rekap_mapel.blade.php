@extends('layouts.dashboard.template')

@section('title', 'Rekap Nilai Per Mata Pelajaran')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Nilai Per Mata Pelajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">Nilai</a></li>
                <li class="breadcrumb-item active">Rekap Per Mapel</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Filter Kelas & Mata Pelajaran</h5>
                        
                        <form action="{{ route('nilai.rekap-mapel') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ $selectedTa == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester_id" id="semester_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem->id }}" {{ $selectedSem == $sem->id ? 'selected' : '' }}>
                                            {{ $sem->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mapels as $mp)
                                        <option value="{{ $mp->id }}" {{ $selectedMapel == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('nilai.rekap-mapel') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0d6efd; border-color: #0d6efd;">
                                    <i class="bi bi-search"></i> Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary fw-bold p-0 mb-0">Rekap Nilai Per Mapel</h5>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Rekap</button>
                        </div>

                        @if(count($students) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light fw-bold text-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 120px;">NISN</th>
                                        <th class="text-start">Nama Siswa</th>
                                        <th>Nilai Harian</th>
                                        <th>Nilai MID</th>
                                        <th>Nilai MID+</th>
                                        <th>Nilai PAS</th>
                                        <th>Nilai PAS+</th>
                                        <th>Nilai Rata2</th>
                                        <th class="table-success">Nilai Raport</th>
                                        <th>TP Optimal</th>
                                        <th>TP Yang Perlu Peningkatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $siswa)
                                        @php
                                            $rec = $siswa->nilai_record;
                                            $harian = $rec && $rec->nilai_harian !== null ? floatval($rec->nilai_harian) : null;
                                            $mid = $rec && $rec->nilai_mid !== null ? floatval($rec->nilai_mid) : null;
                                            $midPlus = $rec && $rec->nilai_mid_plus !== null ? floatval($rec->nilai_mid_plus) : null;
                                            $pas = $rec && $rec->nilai_pas !== null ? floatval($rec->nilai_pas) : null;
                                            $pasPlus = $rec && $rec->nilai_pas_plus !== null ? floatval($rec->nilai_pas_plus) : null;
                                            
                                            $midVal = $midPlus !== null ? $midPlus : $mid;
                                            $pasVal = $pasPlus !== null ? $pasPlus : $pas;
                                            
                                            $rata2 = null;
                                            if ($harian !== null && $midVal !== null && $pasVal !== null) {
                                                $rata2 = ($harian + $midVal + $pasVal) / 3;
                                            }

                                            // Determine TP description text based on raport score threshold (Kurikulum Merdeka)
                                            $tpOpt = '.....';
                                            $tpPen = '.....';
                                            if ($rec && $rec->nilai_raport !== null && $selectedMapelModel) {
                                                if ($rec->nilai_raport >= 75) {
                                                    $tpOpt = $selectedMapelModel->tp_optimal ?: '.....';
                                                } else {
                                                    $tpPen = $selectedMapelModel->tp_peningkatan ?: '.....';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td class="text-start fw-semibold">{{ $siswa->nama_siswa }}</td>
                                            <td>{{ $harian !== null ? number_format($harian, 1) : '.....' }}</td>
                                            <td>{{ $mid !== null ? number_format($mid, 1) : '.....' }}</td>
                                            <td>{{ $midPlus !== null ? number_format($midPlus, 1) : '.....' }}</td>
                                            <td>{{ $pas !== null ? number_format($pas, 1) : '.....' }}</td>
                                            <td>{{ $pasPlus !== null ? number_format($pasPlus, 1) : '.....' }}</td>
                                            <td class="fw-bold text-secondary">{{ $rata2 !== null ? number_format($rata2, 1) : '.....' }}</td>
                                            <td class="table-success fw-bold">{{ $rec && $rec->nilai_raport !== null ? number_format($rec->nilai_raport, 1) : '.....' }}</td>
                                            <td class="text-start small" style="max-width: 200px;">{{ $tpOpt }}</td>
                                            <td class="text-start small" style="max-width: 200px;">{{ $tpPen }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data siswa ditemukan.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
