@extends('layouts.dashboard.template')

@section('title', 'Rekap Kehadiran Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Kehadiran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekap Kehadiran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Filter Rekap Kehadiran</h5>
                        
                        <form action="{{ route('kehadiran.personal') }}" method="GET" class="row g-3">
                            <div class="col-md-6">
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
                            
                            <div class="col-md-6">
                                <label for="semester_name" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester_name" id="semester_name" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('kehadiran.personal') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-dark btn-sm px-3" style="background-color: #212529; border-color: #212529;">
                                    <i class="bi bi-search"></i> Tampilkan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold p-0 mb-4">Rekap Ketidakhadiran Siswa</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light text-dark fw-bold">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th class="text-start">Mata Pelajaran</th>
                                        <th style="width: 150px; background-color: #fff3cd; color: #856404;">Sakit (Hari)</th>
                                        <th style="width: 150px; background-color: #cce5ff; color: #004085;">Izin (Hari)</th>
                                        <th style="width: 150px; background-color: #f8d7da; color: #721c24;">Alpa (Hari)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($classMapels) > 0)
                                        @foreach($classMapels as $index => $mp)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-start fw-semibold">{{ $mp->nama_mata_pelajaran }}</td>
                                                <td class="fw-bold" style="background-color: #fffdf5;">{{ $attendanceCounts[$mp->id]['Sakit'] ?? 0 }}</td>
                                                <td class="fw-bold" style="background-color: #f7faff;">{{ $attendanceCounts[$mp->id]['Izin'] ?? 0 }}</td>
                                                <td class="fw-bold" style="background-color: #fffbfa;">{{ $attendanceCounts[$mp->id]['Alpa'] ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-muted py-3">Tidak ada data kehadiran yang tercatat untuk periode ini.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
