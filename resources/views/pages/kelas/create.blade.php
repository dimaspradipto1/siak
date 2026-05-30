@extends('layouts.dashboard.template')

@section('title', 'Tambah Kelas')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white"
                                style="width:42px;height:42px;background:linear-gradient(135deg,#1a4fad,#0d9fd8);">
                                <i class="bi bi-house-add fs-5"></i>
                            </div>
                            <h5 class="mb-0">Form Tambah Kelas Baru</h5>
                        </div>

                        <form action="{{ route('kelas.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label fw-semibold">
                                    Nama Kelas <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-fonts"></i></span>
                                    <input type="text" id="nama_kelas" name="nama_kelas"
                                        class="form-control @error('nama_kelas') is-invalid @enderror"
                                        value="{{ old('nama_kelas') }}"
                                        placeholder="Contoh: I A, II B, III C">
                                    @error('nama_kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tingkat" class="form-label fw-semibold">
                                    Tingkat <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-bar-chart-steps"></i></span>
                                    <select id="tingkat" name="tingkat"
                                        class="form-select @error('tingkat') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Tingkat --</option>
                                        @foreach(['1', '2', '3', '4', '5', '6'] as $tingkat)
                                            <option value="{{ $tingkat }}" {{ old('tingkat') === $tingkat ? 'selected' : '' }}>Kelas {{ $tingkat }}</option>
                                        @endforeach
                                    </select>
                                    @error('tingkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="ruangan" class="form-label fw-semibold">
                                    Ruangan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-door-open"></i></span>
                                    <input type="text" id="ruangan" name="ruangan"
                                        class="form-control @error('ruangan') is-invalid @enderror"
                                        value="{{ old('ruangan') }}"
                                        placeholder="Contoh: R-01, R-02, Lab Komputer">
                                    @error('ruangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: `<ul class="text-start ps-3 mb-0">{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Oke, Perbaiki',
            });
        @endif
    </script>
@endpush
