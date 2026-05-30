@extends('layouts.dashboard.template')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Mata Pelajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('matapelajaran.index') }}">Mata Pelajaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('matapelajaran.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_mata_pelajaran" class="form-label fw-semibold">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                                <input type="text" id="nama_mata_pelajaran" name="nama_mata_pelajaran" class="form-control @error('nama_mata_pelajaran') is-invalid @enderror" value="{{ old('nama_mata_pelajaran') }}">
                                @error('nama_mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="kkm" class="form-label fw-semibold">KKM (Kriteria Ketuntasan Minimal) <span class="text-danger">*</span></label>
                                <input type="number" id="kkm" name="kkm" class="form-control @error('kkm') is-invalid @enderror" value="{{ old('kkm', 75) }}">
                                @error('kkm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('matapelajaran.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
