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
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('matapelajaran.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kode_mapel" class="form-label fw-semibold">Kode Mapel <span class="text-danger">*</span></label>
                                    <input type="text" id="kode_mapel" name="kode_mapel" class="form-control @error('kode_mapel') is-invalid @enderror" value="{{ old('kode_mapel') }}" placeholder="Contoh: MP001">
                                    @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_mata_pelajaran" class="form-label fw-semibold">Nama Mapel <span class="text-danger">*</span></label>
                                    <input type="text" id="nama_mata_pelajaran" name="nama_mata_pelajaran" class="form-control @error('nama_mata_pelajaran') is-invalid @enderror" value="{{ old('nama_mata_pelajaran') }}" placeholder="Contoh: Matematika">
                                    @error('nama_mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kkm" class="form-label fw-semibold">KKM <span class="text-danger">*</span></label>
                                    <input type="number" id="kkm" name="kkm" class="form-control @error('kkm') is-invalid @enderror" value="{{ old('kkm', 75) }}" min="0" max="100">
                                    @error('kkm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="guru_id" class="form-label fw-semibold">Guru Pengajar <span class="text-danger">*</span></label>
                                    <select id="guru_id" name="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach($gurus as $g)
                                            <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->pegawai?->nama_pegawai ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('guru_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                        <option value="">-- Pilih Tahun Ajaran --</option>
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama_tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                    <select id="semester_id" name="semester_id" class="form-select @error('semester_id') is-invalid @enderror">
                                        <option value="">-- Pilih Semester --</option>
                                        @foreach($semesters as $s)
                                            <option value="{{ $s->id }}" {{ old('semester_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_semester }} - {{ $s->tahunAjaran?->nama_tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                    @error('semester_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hari_mengajar" class="form-label fw-semibold">Hari Mengajar <span class="text-danger">*</span></label>
                                    <select id="hari_mengajar" name="hari_mengajar" class="form-select @error('hari_mengajar') is-invalid @enderror">
                                        <option value="">-- Pilih Hari --</option>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                            <option value="{{ $hari }}" {{ old('hari_mengajar') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                        @endforeach
                                    </select>
                                    @error('hari_mengajar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="jam_mengajar" class="form-label fw-semibold">Jam Mengajar <span class="text-danger">*</span></label>
                                <input type="text" id="jam_mengajar" name="jam_mengajar" class="form-control @error('jam_mengajar') is-invalid @enderror" value="{{ old('jam_mengajar') }}" placeholder="Contoh: 07:30 - 09:00">
                                @error('jam_mengajar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="tp_optimal" class="form-label fw-semibold">TP yang Optimal</label>
                                <textarea id="tp_optimal" name="tp_optimal" class="form-control @error('tp_optimal') is-invalid @enderror" rows="3" placeholder="Masukkan Tujuan Pembelajaran yang sudah dicapai dengan optimal oleh siswa">{{ old('tp_optimal') }}</textarea>
                                @error('tp_optimal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="tp_peningkatan" class="form-label fw-semibold">TP Yang Perlu Peningkatan</label>
                                <textarea id="tp_peningkatan" name="tp_peningkatan" class="form-control @error('tp_peningkatan') is-invalid @enderror" rows="3" placeholder="Masukkan Tujuan Pembelajaran yang memerlukan bimbingan/peningkatan bagi siswa">{{ old('tp_peningkatan') }}</textarea>
                                @error('tp_peningkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
