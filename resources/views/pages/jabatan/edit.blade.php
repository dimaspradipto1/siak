@extends('layouts.dashboard.template')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="pagetitle">
        <h1>Edit Jabatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                                style="width:42px;height:42px;background:linear-gradient(135deg,#e0a800,#ffc107);">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-warning">Form Edit Jabatan</h5>
                        </div>

                        <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" id="formEdit">
                            @csrf
                            @method('PUT')

                            {{-- Kode Jabatan --}}
                            <div class="mb-3">
                                <label for="kode_jabatan" class="form-label fw-semibold">
                                    Kode Jabatan
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" id="kode_jabatan" name="kode_jabatan"
                                        class="form-control @error('kode_jabatan') is-invalid @enderror"
                                        value="{{ old('kode_jabatan', $jabatan->kode_jabatan ?? ('JBT-' . str_pad($jabatan->id, 3, '0', STR_PAD_LEFT))) }}"
                                        placeholder="Contoh: JBT-001">
                                    @error('kode_jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Jabatan --}}
                            <div class="mb-3">
                                <label for="nama_jabatan" class="form-label fw-semibold">
                                    Nama Jabatan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" id="nama_jabatan" name="nama_jabatan"
                                        class="form-control @error('nama_jabatan') is-invalid @enderror"
                                        value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                                        placeholder="Contoh: Kepala Tata Usaha" required>
                                    @error('nama_jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keterangan / Deskripsi --}}
                            <div class="mb-3">
                                <label for="keterangan" class="form-label fw-semibold">
                                    Deskripsi / Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    placeholder="Tulis deskripsi singkat jabatan">{{ old('keterangan', $jabatan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    Status
                                </label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="Aktif" {{ old('status', $jabatan->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Non-Aktif" {{ old('status', $jabatan->status ?? '') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
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
