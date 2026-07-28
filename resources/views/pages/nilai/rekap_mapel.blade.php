@extends('layouts.dashboard.template')

@section('title', 'Rekap Nilai Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Nilai Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekap Nilai Siswa</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Form Rekap Nilai Siswa</h5>
                        
                        <form action="{{ route('nilai.rekap-mapel') }}" method="GET" class="row g-4">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold text-dark">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ $selectedTa == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="semester_name" class="form-label fw-semibold text-dark">Semester</label>
                                <select name="semester_name" id="semester_name" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    <option value="Semester 1 (Ganjil)" {{ (isset($selectedSemName) && $selectedSemName == 'Semester 1 (Ganjil)') || (!isset($selectedSemName) && request('semester_name') == 'Semester 1 (Ganjil)') ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ (isset($selectedSemName) && $selectedSemName == 'Semester 2 (Genap)') || (!isset($selectedSemName) && request('semester_name') == 'Semester 2 (Genap)') ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kelas_id" class="form-label fw-semibold text-dark">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold text-dark">Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($mapels as $mp)
                                        <option value="{{ $mp->id }}" {{ $selectedMapel == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end align-items-center gap-4 pt-2">
                                <a href="{{ route('nilai.rekap-mapel') }}" class="text-dark fw-bold text-decoration-none small" style="font-size: 0.95rem;">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Tampilkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title text-dark fw-bold p-0 mb-0">Daftar Nilai Siswa</h5>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Rekap</button>
                        </div>

                        @if(count($students) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle text-center table-borderless table-striped">
                                <thead style="border-bottom: 2px solid #dee2e6;">
                                    <tr class="text-dark fw-bold" style="font-size: 1rem;">
                                        <th style="padding: 12px 16px;">NISN</th>
                                        <th class="text-start" style="padding: 12px 16px;">Nama Siswa</th>
                                        <th style="padding: 12px 16px;">Nilai Harian</th>
                                        <th style="padding: 12px 16px;">Nilai MID+</th>
                                        <th style="padding: 12px 16px;">Nilai PAS+</th>
                                        <th style="padding: 12px 16px;">Nilai Rata2</th>
                                        <th style="padding: 12px 16px;">Nilai Raport</th>
                                        <th style="padding: 12px 16px;">TP Optimal</th>
                                        <th style="padding: 12px 16px;">TP Yang Perlu Peningkatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $siswa)
                                        @php
                                            $rec = $siswa->nilai_record;

                                            $harian = $rec && $rec->nilai_harian !== null ? floatval($rec->nilai_harian) : null;
                                            $midPlus = $rec && $rec->nilai_mid_plus !== null ? floatval($rec->nilai_mid_plus) : null;
                                            $pasPlus = $rec && $rec->nilai_pas_plus !== null ? floatval($rec->nilai_pas_plus) : null;
                                            $rata2 = $siswa->nilai_rata2_calc;
                                            $raport = $rec && $rec->nilai_raport !== null ? floatval($rec->nilai_raport) : null;

                                            if (!function_exists('formatVal')) {
                                                function formatVal($val) {
                                                    if ($val === null) return '-';
                                                    return $val == intval($val) ? intval($val) : number_format($val, 1);
                                                }
                                            }
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="text-dark" style="padding: 14px 16px;">{{ $siswa->nisn }}</td>
                                            <td class="text-start fw-bold text-dark" style="padding: 14px 16px;">{{ $siswa->nama_siswa }}</td>
                                            <td style="padding: 14px 16px;">{{ formatVal($harian) }}</td>
                                            <td style="padding: 14px 16px;">{{ formatVal($midPlus) }}</td>
                                            <td style="padding: 14px 16px;">{{ formatVal($pasPlus) }}</td>
                                            <td class="fw-semibold text-primary" style="padding: 14px 16px;">{{ formatVal($rata2) }}</td>
                                            <td class="fw-bold text-dark" style="padding: 14px 16px;">{{ formatVal($raport) }}</td>
                                            <td class="text-start" style="padding: 14px 16px;">{{ $rec && $rec->tp_optimal ? $rec->tp_optimal : '-' }}</td>
                                            <td class="text-start" style="padding: 14px 16px;">{{ $rec && $rec->tp_perlu_peningkatan ? $rec->tp_perlu_peningkatan : '-' }}</td>
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
