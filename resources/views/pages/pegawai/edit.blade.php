@extends('layouts.dashboard.template')

@section('title', 'Edit Pegawai')

@section('content')
    <div class="pagetitle">
        <h1>Edit Pegawai</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
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
                            <h5 class="mb-0">Form Edit Data Pegawai</h5>
                        </div>

                        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" id="formEdit">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- NIP --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nip" class="form-label fw-semibold">
                                        NIP <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" id="nip" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror"
                                            value="{{ old('nip', $pegawai->nip) }}"
                                            placeholder="Masukkan NIP"
                                            autocomplete="off">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nama Pegawai --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nama_pegawai" class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" id="nama_pegawai" name="nama_pegawai"
                                            class="form-control @error('nama_pegawai') is-invalid @enderror"
                                            value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"
                                            placeholder="Masukkan nama lengkap">
                                        @error('nama_pegawai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Jenis Kelamin --}}
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">
                                        Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                        <select id="jenis_kelamin" name="jenis_kelamin"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Jabatan --}}
                                <div class="col-md-6 mb-3">
                                    <label for="jabatan" class="form-label fw-semibold">
                                        Jabatan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        <input type="text" id="jabatan" name="jabatan"
                                            class="form-control @error('jabatan') is-invalid @enderror"
                                            value="{{ old('jabatan', $pegawai->jabatan) }}"
                                            placeholder="Contoh: Kepala Sekolah, Guru Kelas, Operator">
                                        @error('jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Tempat Lahir --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label fw-semibold">
                                        Tempat Lahir <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                            value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}"
                                            placeholder="Masukkan tempat lahir">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tgl_lahir" class="form-label fw-semibold">
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" id="tgl_lahir" name="tgl_lahir"
                                            class="form-control @error('tgl_lahir') is-invalid @enderror"
                                            value="{{ old('tgl_lahir', $pegawai->tgl_lahir ? $pegawai->tgl_lahir->format('Y-m-d') : '') }}">
                                        @error('tgl_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Agama --}}
                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label fw-semibold">
                                        Agama <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-heart"></i></span>
                                        <select id="agama" name="agama"
                                            class="form-select @error('agama') is-invalid @enderror">
                                            <option value="" disabled>-- Pilih Agama --</option>
                                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agm)
                                                <option value="{{ $agm }}" {{ old('agama', $pegawai->agama) === $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                            @endforeach
                                        </select>
                                        @error('agama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nomor WhatsApp --}}
                                <div class="col-md-6 mb-3">
                                    <label for="nomor_wa" class="form-label fw-semibold">
                                        Nomor WhatsApp
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                        <input type="text" id="nomor_wa" name="nomor_wa"
                                            class="form-control @error('nomor_wa') is-invalid @enderror"
                                            value="{{ old('nomor_wa', $pegawai->nomor_wa) }}"
                                            placeholder="Contoh: 081234567890">
                                        @error('nomor_wa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-semibold">
                                    Alamat Tempat Tinggal
                                </label>
                                <textarea id="alamat" name="alamat" rows="3"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat', $pegawai->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
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
        // SweetAlert error validasi jika ada error di server-side validation
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
