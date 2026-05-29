@extends('layouts.dashboard.template')

@section('title', 'Tambah Guru')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Guru</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
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
                                <i class="bi bi-person-plus-fill fs-5"></i>
                            </div>
                            <h5 class="mb-0">Form Tambah Guru Baru</h5>
                        </div>

                        <form action="{{ route('guru.store') }}" method="POST" id="formCreate">
                            @csrf

                            {{-- Pilih Pegawai --}}
                            <div class="mb-3">
                                <label for="pegawai_id" class="form-label fw-semibold">
                                    Pilih Pegawai <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <select id="pegawai_id" name="pegawai_id"
                                        class="form-select @error('pegawai_id') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Pegawai --</option>
                                        @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" data-nip="{{ $pegawai->nip }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama_pegawai }} (NIP: {{ $pegawai->nip }} - {{ $pegawai->jabatan }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pegawai_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">
                                    Hanya menampilkan pegawai yang belum didaftarkan sebagai Guru.
                                </div>
                            </div>

                            <div class="row">
                                {{-- NIP Guru --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nip_guru" class="form-label fw-semibold">
                                        NIP Guru <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" id="nip_guru" name="nip_guru"
                                            class="form-control @error('nip_guru') is-invalid @enderror"
                                            value="{{ old('nip_guru') }}"
                                            placeholder="Masukkan NIP Guru">
                                        @error('nip_guru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Golongan --}}
                                <div class="col-md-6 mb-3">
                                    <label for="golongan" class="form-label fw-semibold">
                                        Golongan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-award"></i></span>
                                        <select id="golongan" name="golongan"
                                            class="form-select @error('golongan') is-invalid @enderror">
                                            <option value="" disabled selected>-- Pilih Golongan --</option>
                                            @foreach(['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'] as $gol)
                                                <option value="{{ $gol }}" {{ old('golongan') === $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                            @endforeach
                                        </select>
                                        @error('golongan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Pendidikan Terakhir --}}
                            <div class="mb-4">
                                <label for="pendidikan_terakhir" class="form-label fw-semibold">
                                    Pendidikan Terakhir <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir"
                                        class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                        value="{{ old('pendidikan_terakhir') }}"
                                        placeholder="Contoh: S1 PGSD, S1 Pendidikan Agama Islam">
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('guru.index') }}" class="btn btn-secondary">
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
        // Auto-fill NIP Guru saat memilih Pegawai
        document.getElementById('pegawai_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const nip = selectedOption.dataset.nip;
            const nipGuruInput = document.getElementById('nip_guru');
            if (nipGuruInput && !nipGuruInput.value) {
                nipGuruInput.value = nip;
            }
        });

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
