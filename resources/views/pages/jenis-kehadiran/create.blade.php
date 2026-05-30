@extends('layouts.dashboard.template')

@section('title', 'Tambah Jenis Kehadiran')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Jenis Kehadiran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jeniskehadiran.index') }}">Jenis Kehadiran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('jeniskehadiran.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="kode_kehadiran" class="form-label fw-semibold">Kode Kehadiran <span class="text-danger">*</span></label>
                                <input type="text" id="kode_kehadiran" name="kode_kehadiran" class="form-control @error('kode_kehadiran') is-invalid @enderror" value="{{ old('kode_kehadiran') }}" placeholder="Contoh: H, S, I, A">
                                @error('kode_kehadiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_kehadiran" class="form-label fw-semibold">Nama Kehadiran <span class="text-danger">*</span></label>
                                <input type="text" id="nama_kehadiran" name="nama_kehadiran" class="form-control @error('nama_kehadiran') is-invalid @enderror" value="{{ old('nama_kehadiran') }}" placeholder="Contoh: Hadir, Sakit">
                                @error('nama_kehadiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('jeniskehadiran.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
