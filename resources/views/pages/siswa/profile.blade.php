@extends('layouts.dashboard.template')

@php
    $isReadOnly = in_array(auth()->user()?->roles, ['siswa', 'orang tua']);
    $disabledAttr = $isReadOnly ? 'disabled' : '';
@endphp

@section('title', 'Profile Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Profile Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile Siswa</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('siswa.profile.update') }}" method="POST">
                    @csrf
                    
                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                        <div class="card-body pt-4">
                            <h5 class="card-title text-dark fw-bold mb-4 p-0">Form Data Profile Siswa</h5>
                            
                            <h6 class="text-dark fw-bold border-bottom pb-2 mb-4">Data Pribadi</h6>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label for="nisn" class="form-label fw-semibold text-dark">NISN</label>
                                    <input type="text" id="nisn" class="form-control py-2 bg-light text-muted" value="{{ $siswa->nisn }}" readonly disabled style="border-radius: 8px;">
                                </div>

                                <div class="col-md-4">
                                    <label for="nama_siswa" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control py-2 bg-light @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nama_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select py-2 bg-light @error('jenis_kelamin') is-invalid @enderror" {{ $disabledAttr }} style="border-radius: 8px;">
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tempat_lahir" class="form-label fw-semibold text-dark">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control py-2 bg-light @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tgl_lahir" class="form-label fw-semibold text-dark">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control py-2 bg-light @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir', $siswa->tgl_lahir) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="agama" class="form-label fw-semibold text-dark">Agama</label>
                                    <select name="agama" id="agama" class="form-select py-2 bg-light @error('agama') is-invalid @enderror" {{ $disabledAttr }} style="border-radius: 8px;">
                                        <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen Protestan" {{ old('agama', $siswa->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                        <option value="Katolik" {{ old('agama', $siswa->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama', $siswa->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', $siswa->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Khonghucu" {{ old('agama', $siswa->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nomor_wa" class="form-label fw-semibold text-dark">Whatsapp</label>
                                    <input type="text" name="nomor_wa" id="nomor_wa" class="form-control py-2 bg-light @error('nomor_wa') is-invalid @enderror" value="{{ old('nomor_wa', $siswa->nomor_wa) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nomor_wa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email_siswa" class="form-label fw-semibold text-dark">Email</label>
                                    <input type="email" name="email_siswa" id="email_siswa" class="form-control py-2 bg-light @error('email_siswa') is-invalid @enderror" value="{{ old('email_siswa', $siswa->user->email ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('email_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="alamat" class="form-label fw-semibold text-dark">Alamat Lengkap</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control py-2 bg-light @error('alamat') is-invalid @enderror" {{ $disabledAttr }} style="border-radius: 8px;">{{ old('alamat', $siswa->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tgl_masuk" class="form-label fw-semibold text-dark">Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control py-2 bg-light @error('tgl_masuk') is-invalid @enderror" value="{{ old('tgl_masuk', $siswa->tgl_masuk) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('tgl_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                        <div class="card-body pt-4">
                            <h6 class="text-dark fw-bold border-bottom pb-2 mb-4">Data Orang Tua</h6>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label for="nama_ayah" class="form-label fw-semibold text-dark">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" id="nama_ayah" class="form-control py-2 bg-light @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $orangTua->nama_ayah ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pekerjaan_ayah" class="form-label fw-semibold text-dark">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control py-2 bg-light @error('pekerjaan_ayah') is-invalid @enderror" value="{{ old('pekerjaan_ayah', $orangTua->pekerjaan_ayah ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nomor_wa_ayah" class="form-label fw-semibold text-dark">No. Whatsapp Ayah</label>
                                    <input type="text" name="nomor_wa_ayah" id="nomor_wa_ayah" class="form-control py-2 bg-light @error('nomor_wa_ayah') is-invalid @enderror" value="{{ old('nomor_wa_ayah', $orangTua->nomor_wa ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nomor_wa_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nama_ibu" class="form-label fw-semibold text-dark">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control py-2 bg-light @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $orangTua->nama_ibu ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pekerjaan_ibu" class="form-label fw-semibold text-dark">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control py-2 bg-light @error('pekerjaan_ibu') is-invalid @enderror" value="{{ old('pekerjaan_ibu', $orangTua->pekerjaan_ibu ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('pekerjaan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nomor_wa_ibu" class="form-label fw-semibold text-dark">No. Whatsapp Ibu</label>
                                    <input type="text" name="nomor_wa_ibu" id="nomor_wa_ibu" class="form-control py-2 bg-light @error('nomor_wa_ibu') is-invalid @enderror" value="{{ old('nomor_wa_ibu', $orangTua->nomor_wa_ibu ?? '') }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('nomor_wa_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="alamat_ortu" class="form-label fw-semibold text-dark">Alamat Orang Tua</label>
                                    <textarea name="alamat_ortu" id="alamat_ortu" rows="3" class="form-control py-2 bg-light @error('alamat_ortu') is-invalid @enderror" {{ $disabledAttr }} style="border-radius: 8px;">{{ old('alamat_ortu', $orangTua->alamat ?? '') }}</textarea>
                                    @error('alamat_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email_ortu" class="form-label fw-semibold text-dark">Email Orang Tua</label>
                                    <input type="email" name="email_ortu" id="email_ortu" class="form-control py-2 bg-light @error('email_ortu') is-invalid @enderror" value="{{ old('email_ortu', $orangTua->email ?? ($orangTua->user->email ?? '')) }}" {{ $disabledAttr }} style="border-radius: 8px;">
                                    @error('email_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(!$isReadOnly)
                            <div class="d-flex justify-content-end mt-5">
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; font-weight: bold; border-radius: 8px;">
                                    Simpan Perubahan
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
