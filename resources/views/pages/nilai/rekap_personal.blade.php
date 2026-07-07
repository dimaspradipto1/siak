@extends('layouts.dashboard.template')

@section('title', 'Rekap Nilai Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Nilai Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekap Nilai</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Filter Periode Akademik</h5>
                        
                        <form action="{{ route('nilai.index') }}" method="GET" class="row g-4">
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
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end align-items-center gap-4 pt-2">
                                <a href="{{ route('nilai.index') }}" class="text-dark fw-bold text-decoration-none small" style="font-size: 0.95rem;">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Tampilkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title text-dark fw-bold p-0 mb-1">Daftar Nilai Hasil Belajar</h5>
                                <p class="text-muted small mb-0">Nama Siswa: <strong class="text-dark">{{ $siswa->nama_siswa }}</strong> (NISN: {{ $siswa->nisn }})</p>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Rekap</button>
                        </div>

                        @if(count($grades) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle text-center table-borderless table-striped">
                                <thead style="border-bottom: 2px solid #dee2e6;">
                                    <tr class="text-dark fw-bold" style="font-size: 1rem;">
                                        <th class="text-start" style="padding: 12px 16px;">Mata Pelajaran</th>
                                        <th style="padding: 12px 16px; width: 180px;">Nilai Harian</th>
                                        <th style="padding: 12px 16px; width: 180px;">Nilai MID+</th>
                                        <th style="padding: 12px 16px; width: 180px;">Nilai PAS+</th>
                                        <th style="padding: 12px 16px; width: 180px;">Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $g)
                                        @php
                                            $rec = $g['nilai_record'];
                                            
                                            $harian = $rec && $rec->nilai_harian !== null ? floatval($rec->nilai_harian) : null;
                                            $midPlus = $rec && $rec->nilai_mid_plus !== null ? floatval($rec->nilai_mid_plus) : ($rec && $rec->nilai_mid !== null ? floatval($rec->nilai_mid) : null);
                                            $pasPlus = $rec && $rec->nilai_pas_plus !== null ? floatval($rec->nilai_pas_plus) : ($rec && $rec->nilai_pas !== null ? floatval($rec->nilai_pas) : null);
                                            $akhir = $rec && $rec->nilai_raport !== null ? floatval($rec->nilai_raport) : null;

                                            if (!function_exists('formatValPersonal')) {
                                                function formatValPersonal($val) {
                                                    if ($val === null) return '-';
                                                    return $val == intval($val) ? intval($val) : number_format($val, 1);
                                                }
                                            }
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="text-start fw-bold text-dark" style="padding: 14px 16px;">{{ $g['mapel'] }}</td>
                                            <td style="padding: 14px 16px;">{{ formatValPersonal($harian) }}</td>
                                            <td style="padding: 14px 16px;">{{ formatValPersonal($midPlus) }}</td>
                                            <td style="padding: 14px 16px;">{{ formatValPersonal($pasPlus) }}</td>
                                            <td class="fw-bold text-primary" style="padding: 14px 16px;">{{ formatValPersonal($akhir) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Belum ada data nilai hasil belajar untuk periode terpilih.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
