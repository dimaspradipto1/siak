@extends('layouts.dashboard.template')

@section('title', 'Tambah Data Mata Pelajaran')

@section('content')
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark fs-4">Form Tambah Mata Pelajaran</h1>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <form action="{{ route('matapelajaran.store') }}" method="POST" id="formTambahMapel">
                            @csrf

                            {{-- Kode Mata Pelajaran --}}
                            <div class="mb-3">
                                <label for="kode_mapel" class="form-label fw-medium text-secondary">Kode Mata Pelajaran</label>
                                <input type="text" id="kode_mapel" name="kode_mapel" 
                                    class="form-control rounded-3 @error('kode_mapel') is-invalid @enderror" 
                                    value="{{ old('kode_mapel') }}" placeholder="Masukkan Kode Mata Pelajaran">
                                @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Nama Mata Pelajaran --}}
                            <div class="mb-3">
                                <label for="nama_mata_pelajaran" class="form-label fw-medium text-secondary">Nama Mata Pelajaran</label>
                                <input type="text" id="nama_mata_pelajaran" name="nama_mata_pelajaran" 
                                    class="form-control rounded-3 @error('nama_mata_pelajaran') is-invalid @enderror" 
                                    value="{{ old('nama_mata_pelajaran') }}" required placeholder="Masukkan Nama Mata Pelajaran">
                                @error('nama_mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- KKM --}}
                            <div class="mb-3">
                                <label for="kkm" class="form-label fw-medium text-secondary">KKM</label>
                                <input type="number" id="kkm" name="kkm" 
                                    class="form-control rounded-3 @error('kkm') is-invalid @enderror" 
                                    value="{{ old('kkm', 75) }}" placeholder="Masukkan KKM">
                                @error('kkm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- TP yang Diukur & Tercapai Optimal --}}
                            <div class="mb-3">
                                <label for="tp_optimal" class="form-label fw-medium text-secondary">TP yang Diukur & Tercapai Optimal</label>
                                <input type="text" id="tp_optimal" name="tp_optimal" 
                                    class="form-control rounded-3 @error('tp_optimal') is-invalid @enderror" 
                                    value="{{ old('tp_optimal') }}" placeholder="Masukkan TP yang Diukur & Tercapai Optimal">
                                @error('tp_optimal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- TP yang Diukur & Perlu Peningkatan --}}
                            <div class="mb-4">
                                <label for="tp_peningkatan" class="form-label fw-medium text-secondary">TP yang Diukur & Perlu Peningkatan</label>
                                <input type="text" id="tp_peningkatan" name="tp_peningkatan" 
                                    class="form-control rounded-3 @error('tp_peningkatan') is-invalid @enderror" 
                                    value="{{ old('tp_peningkatan') }}" placeholder="Masukkan TP yang Diukur & Perlu Peningkatan">
                                @error('tp_peningkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top">
                                <a href="{{ route('matapelajaran.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2 rounded-3">
                                    Simpan
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
            });
        @endif
    </script>
@endpush
