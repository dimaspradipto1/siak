@extends('layouts.dashboard.template')

@section('title', 'Input Kehadiran')

@section('content')
    <div class="pagetitle">
        <h1>Input Kehadiran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Kehadiran</a></li>
                <li class="breadcrumb-item active">Input</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('kehadiran.store') }}" method="POST">
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
                                    <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}">
                                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="jenis_kehadiran_id" class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                    <select id="jenis_kehadiran_id" name="jenis_kehadiran_id" class="form-select @error('jenis_kehadiran_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        @foreach($jenisKehadirans as $jk)
                                            <option value="{{ $jk->id }}" {{ old('jenis_kehadiran_id') == $jk->id ? 'selected' : '' }}>{{ $jk->nama_kehadiran }} ({{ $jk->kode_kehadiran }})</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kehadiran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                                <textarea id="keterangan" name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('kehadiran.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Kehadiran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
