@extends('layouts.dashboard.template')

@php
if (!function_exists('abbreviateMapel')) {
    function abbreviateMapel($name) {
        $map = [
            'Pendidikan Agama Islam' => 'PAI',
            'Pendidikan Agama Islam dan Budi Pekerti' => 'PAI',
            'Pendidikan Pancasila dan Kewarganegaraan' => 'PKN',
            'Pendidikan Pancasila' => 'PKN',
            'Bahasa Indonesia' => 'B.INDO',
            'Matematika' => 'MTK',
            'Ilmu Pengetahuan Alam dan Sosial' => 'IPAS',
            'Ilmu Pengetahuan Alam' => 'IPA',
            'Ilmu Pengetahuan Sosial' => 'IPS',
            'Seni Budaya dan Prakarya' => 'SBDP',
            'Seni Budaya dan Musik' => 'SBDM',
            'Seni Rupa' => 'Seni Rupa',
            'Bahasa Inggris' => 'B.ING',
            'Pendidikan Jasmani, Olahraga, dan Kesehatan' => 'PJOK',
        ];
        return $map[$name] ?? $name;
    }
}
@endphp

@section('title', 'Rekap Kehadiran Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Kehadiran Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Kehadiran</a></li>
                <li class="breadcrumb-item active">Rekap Kehadiran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Rekap Kehadiran Siswa</h5>
                        
                        <form action="{{ route('kehadiran.rekap') }}" method="GET" class="row g-3">
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
                                <label for="semester_name" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester_name" id="semester_name" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
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
                                <label for="jenis_kehadiran_id" class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                <select name="jenis_kehadiran_id" id="jenis_kehadiran_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Status Kehadiran --</option>
                                    @foreach($jenisKehadirans as $jk)
                                        <option value="{{ $jk->id }}" {{ $selectedJenisKehadiran == $jk->id ? 'selected' : '' }}>
                                            {{ $jk->nama_kehadiran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('kehadiran.rekap') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-dark btn-sm px-3" style="background-color: #212529; border-color: #212529;">
                                    <i class="bi bi-search"></i> Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedJenisKehadiran)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <div class="text-center mb-3">
                            <h5 class="fw-bold p-0 mb-1 text-dark" style="font-size: 1.1rem;">Jumlah Kehadiran</h5>
                            <small class="text-secondary">Status Kehadiran: <span class="fw-semibold text-primary">{{ $selectedJenisModel->nama_kehadiran ?? '-' }}</span></small>
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
                                            <th>{{ abbreviateMapel($mp->nama_mata_pelajaran) }}</th>
                                        @endforeach
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
                                                    {{ $siswa->attendance_counts[$mp->id] ?? 0 }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('kehadiran.rekap.print', request()->all()) }}" target="_blank" class="btn btn-dark btn-sm px-4" style="background-color: #212529; border-color: #212529;">
                                <i class="bi bi-printer-fill me-1"></i> Cetak
                            </a>
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
