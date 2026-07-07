@extends('layouts.dashboard.template')

@section('title', 'Rekap Nilai Raport')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Nilai Raport</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">Nilai</a></li>
                <li class="breadcrumb-item active">Rekap Raport</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Filter Kelas</h5>
                        
                        <form action="{{ route('nilai.rekap-raport') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
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
                            
                            <div class="col-md-4">
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

                            <div class="col-md-4">
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

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('nilai.rekap-raport') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0d6efd; border-color: #0d6efd;">
                                    <i class="bi bi-search"></i> Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary fw-bold p-0 mb-0">Rekap Nilai Raport Kelas</h5>
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
                                        @foreach($classMapels as $mp)
                                            <th>{{ $mp->nama_mata_pelajaran }}</th>
                                        @endforeach
                                        <th class="table-success" style="width: 100px;">Rata-rata</th>
                                        <th class="table-success" style="width: 80px;">Predikat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td class="text-start fw-semibold">{{ $siswa->nama_siswa }}</td>
                                            @foreach($classMapels as $mp)
                                                <td>
                                                    {{ $siswa->grades[$mp->id] !== null ? number_format($siswa->grades[$mp->id], 1) : '.....' }}
                                                </td>
                                            @endforeach
                                            <td class="table-success fw-bold">{{ $siswa->average !== null ? number_format($siswa->average, 1) : '.....' }}</td>
                                            <td class="table-success fw-bold text-success">{{ $siswa->predikat !== '-' ? $siswa->predikat : '.....' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data siswa atau mata pelajaran yang terdaftar.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
