@extends('layouts.dashboard.template')

@section('title', 'Input Nilai')

@section('content')
    <div class="pagetitle">
        <h1>Input Nilai</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">Nilai</a></li>
                <li class="breadcrumb-item active">Input</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('nilai.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="siswa_id" class="form-label fw-semibold">Pilih Siswa <span class="text-danger">*</span></label>
                                    <select id="siswa_id" name="siswa_id" class="form-select select2 @error('siswa_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Siswa --</option>
                                        @foreach($siswas as $siswa)
                                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama_siswa }} ({{ $siswa->kelas->nama_kelas ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                    @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select id="mata_pelajaran_id" name="mata_pelajaran_id" class="form-select select2 @error('mata_pelajaran_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                        @foreach($mapels as $mapel)
                                            <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mata_pelajaran }}</option>
                                        @endforeach
                                    </select>
                                    @error('mata_pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                    <select id="semester_id" name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Semester --</option>
                                        @foreach($semesters as $sem)
                                            <option value="{{ $sem->id }}" {{ old('semester_id') == $sem->id ? 'selected' : '' }}>{{ $sem->nama_semester }}</option>
                                        @endforeach
                                    </select>
                                    @error('semester_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama_tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="nilai" class="form-label fw-semibold">Nilai Angka (0-100) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" id="nilai" name="nilai" class="form-control @error('nilai') is-invalid @enderror" value="{{ old('nilai') }}">
                                    @error('nilai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="predikat" class="form-label fw-semibold">Predikat (A/B/C/D) <span class="text-danger">*</span></label>
                                    <input type="text" id="predikat" name="predikat" class="form-control @error('predikat') is-invalid @enderror" value="{{ old('predikat') }}">
                                    @error('predikat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('nilai.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Nilai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
