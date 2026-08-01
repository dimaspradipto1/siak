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
                <li class="breadcrumb-item active">Rekap Kehadiran Siswa</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Form Rekap Kehadiran Siswa</h5>

                        <form action="{{ route('kehadiran.rekap') }}" method="GET" class="row g-4">
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
                                <label for="jenis_kehadiran_id" class="form-label fw-semibold text-dark">Status Kehadiran</label>
                                <select name="jenis_kehadiran_id" id="jenis_kehadiran_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($jenisKehadirans as $jk)
                                        <option value="{{ $jk->id }}" {{ $selectedStatus == $jk->id ? 'selected' : '' }}>
                                            {{ $jk->nama_kehadiran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end align-items-center gap-4 pt-2">
                                <a href="{{ route('kehadiran.rekap') }}" class="text-dark fw-bold text-decoration-none small" style="font-size: 0.95rem;">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedStatus)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Jumlah Kehadiran</h5>

                        @if(count($students) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light fw-bold text-dark">
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 140px;">NISN</th>
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

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('kehadiran.rekap.print', request()->all()) }}" target="_blank" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold;">
                                Cetak
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
