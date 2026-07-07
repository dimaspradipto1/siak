@extends('layouts.dashboard.template')

@section('title', 'Tambah Jabatan')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Jabatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
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
                                <i class="bi bi-briefcase fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-primary">Form Tambah Jabatan</h5>
                        </div>

                        <form action="{{ route('jabatan.store') }}" method="POST" id="formCreate">
                            @csrf

                            {{-- Nama Jabatan --}}
                            <div class="mb-3">
                                <label for="nama_jabatan" class="form-label fw-semibold">
                                    Nama Jabatan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" id="nama_jabatan" name="nama_jabatan"
                                        class="form-control @error('nama_jabatan') is-invalid @enderror"
                                        value="{{ old('nama_jabatan') }}"
                                        placeholder="Contoh: Kepala Tata Usaha" required>
                                    @error('nama_jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">
                                    Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    placeholder="Tulis keterangan atau deskripsi singkat jabatan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
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
        // SweetAlert error validasi jika ada error di server-side
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
