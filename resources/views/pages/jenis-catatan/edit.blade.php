@extends('layouts.dashboard.template')

@section('title', 'Edit Jenis Catatan')

@section('content')
    <div class="pagetitle">
        <h1>Edit Jenis Catatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jeniscatatan.index') }}">Jenis Catatan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('jeniscatatan.update', $jeniscatatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="kode" class="form-label fw-semibold">Kode <span class="text-danger">*</span></label>
                                <input type="number" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $jeniscatatan->kode) }}">
                                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_jenis_catatan" class="form-label fw-semibold">Nama Jenis Catatan <span class="text-danger">*</span></label>
                                <input type="text" id="nama_jenis_catatan" name="nama_jenis_catatan" class="form-control @error('nama_jenis_catatan') is-invalid @enderror" value="{{ old('nama_jenis_catatan', $jeniscatatan->nama_jenis_catatan) }}">
                                @error('nama_jenis_catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $jeniscatatan->keterangan) }}</textarea>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('jeniscatatan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
