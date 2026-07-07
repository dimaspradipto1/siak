@extends('layouts.dashboard.template')

@section('title', 'Edit Pengumuman')

@section('content')
    <div class="pagetitle">
        <h1>Edit Pengumuman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 pb-3">
                        <div class="card-body pt-4">
                            <h5 class="card-title p-0 mb-3 fs-5">Informasi Pengumuman</h5>

                            <div class="mb-3">
                                <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $pengumuman->judul) }}" placeholder="Masukkan judul pengumuman">
                                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-0">
                                <label for="keterangan" class="form-label fw-semibold">Isi Pengumuman <span class="text-danger">*</span></label>
                                <textarea id="keterangan" name="keterangan" rows="8" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tulis isi pengumuman secara detail...">{{ old('keterangan', $pengumuman->keterangan) }}</textarea>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 pb-3">
                        <div class="card-body pt-4">
                            <h5 class="card-title p-0 mb-3 fs-5">Target Publikasi</h5>

                            <div class="mb-3">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                    <option value="" disabled>-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $pengumuman->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select id="semester_id" name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                                    <option value="" disabled>-- Pilih Semester --</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem->id }}" {{ old('semester_id', $pengumuman->semester_id) == $sem->id ? 'selected' : '' }}>
                                            {{ $sem->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semester_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                                <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id', $pengumuman->kelas_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-0">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran</label>
                                <select id="mata_pelajaran_id" name="mata_pelajaran_id" class="form-select @error('mata_pelajaran_id') is-invalid @enderror">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($matapelajarans as $mp)
                                        <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id', $pengumuman->mata_pelajaran_id) == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mata_pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body py-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
