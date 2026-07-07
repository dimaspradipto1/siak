@extends('layouts.dashboard.template')

@section('title', 'Tambah Materi Pembelajaran')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Materi Pembelajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materipembelajaran.index') }}">Materi Pembelajaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="{{ route('materipembelajaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 pb-3">
                        <div class="card-body pt-4">
                            <h5 class="card-title p-0 mb-3 fs-5">Form Tambah Data Materi Pembelajaran</h5>

                            <div class="mb-3">
                                <label for="judul_materi" class="form-label fw-semibold">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" id="judul_materi" name="judul_materi" class="form-control @error('judul_materi') is-invalid @enderror" value="{{ old('judul_materi') }}" placeholder="Masukkan judul materi pelajaran">
                                @error('judul_materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi_materi" class="form-label fw-semibold">Deskripsi Materi</label>
                                <textarea id="deskripsi_materi" name="deskripsi_materi" rows="6" class="form-control @error('deskripsi_materi') is-invalid @enderror" placeholder="Tulis ringkasan atau keterangan materi pelajaran...">{{ old('deskripsi_materi') }}</textarea>
                                @error('deskripsi_materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-0">
                                <label for="file_materi" class="form-label fw-semibold">File Materi <span class="text-danger">*</span></label>
                                <input type="file" id="file_materi" name="file_materi" class="form-control @error('file_materi') is-invalid @enderror">
                                <div class="form-text text-muted">Mendukung format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, atau Gambar (Max. 10 MB).</div>
                                @error('file_materi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 pb-3">
                        <div class="card-body pt-4">
                            <h5 class="card-title p-0 mb-3 fs-5">Kategori Pelajaran</h5>

                            <div class="mb-3">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                             <div class="mb-3">
                                <label for="semester_name" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select id="semester_name" name="semester_name" class="form-select @error('semester_name') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    <option value="Semester 1 (Ganjil)" {{ old('semester_name') == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ old('semester_name') == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                                @error('semester_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                             <div class="mb-0">
                                <label for="nama_mata_pelajaran" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select id="nama_mata_pelajaran" name="nama_mata_pelajaran" class="form-select @error('nama_mata_pelajaran') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    @foreach($uniqueMapels as $name)
                                        <option value="{{ $name }}" {{ old('nama_mata_pelajaran') == $name ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nama_mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body py-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('materipembelajaran.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill me-1"></i> Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
