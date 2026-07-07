@extends('layouts.dashboard.template')

@section('title', 'Edit Pembagian Kelas')

@section('content')
    <div class="pagetitle">
        <h1>Edit Pembagian Kelas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pembagiankelas.index') }}">Pembagian Kelas</a></li>
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
                                style="width:42px;height:42px;background:linear-gradient(135deg,#1a4fad,#0d9fd8);">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <h5 class="mb-0">Form Edit Pembagian Kelas</h5>
                        </div>

                        <form action="{{ route('pembagiankelas.update', $pembagianKelas->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold">
                                    Tahun Ajaran <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                    <select id="tahun_ajaran_id" name="tahun_ajaran_id"
                                        class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih Tahun Ajaran --</option>
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $pembagianKelas->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                                {{ $ta->nama_tahun_ajaran }} @if($ta->status == 'Aktif') (Aktif) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahun_ajaran_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="kelas_id" class="form-label fw-semibold">
                                    Kelas <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select id="kelas_id" name="kelas_id"
                                        class="form-select @error('kelas_id') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih Kelas --</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id', $pembagianKelas->kelas_id) == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="siswa_id" class="form-label fw-semibold">
                                    Siswa <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <select id="siswa_id" name="siswa_id"
                                        class="form-select select2 @error('siswa_id') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih Siswa --</option>
                                        @foreach($siswas as $siswa)
                                            <option value="{{ $siswa->id }}" {{ old('siswa_id', $pembagianKelas->siswa_id) == $siswa->id ? 'selected' : '' }}>
                                                {{ $siswa->nama_siswa }} (NISN: {{ $siswa->nisn }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('siswa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('pembagiankelas.index') }}" class="btn btn-secondary">
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
