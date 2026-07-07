@extends('layouts.dashboard.template')

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
                    
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body pt-4">
                            <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Data Profile Siswa</h5>
                            
                            <h6 class="text-dark fw-bold border-bottom pb-2 mb-3">Data Pribadi</h6>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nisn" class="form-label fw-semibold">NISN</label>
                                    <input type="text" id="nisn" class="form-control bg-light" value="{{ $siswa->nisn }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="nama_siswa" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                                    @error('nama_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir', $siswa->tgl_lahir) }}" required>
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="agama" class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                                    <select name="agama" id="agama" class="form-select @error('agama') is-invalid @enderror" required>
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

                                <div class="col-md-4">
                                    <label for="nomor_wa" class="form-label fw-semibold">Whatsapp</label>
                                    <input type="text" name="nomor_wa" id="nomor_wa" class="form-control @error('nomor_wa') is-invalid @enderror" value="{{ old('nomor_wa', $siswa->nomor_wa) }}">
                                    @error('nomor_wa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email_siswa" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email_siswa" id="email_siswa" class="form-control @error('email_siswa') is-invalid @enderror" value="{{ old('email_siswa', $siswa->user->email ?? '') }}" required>
                                    @error('email_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tgl_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                                    <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control @error('tgl_masuk') is-invalid @enderror" value="{{ old('tgl_masuk', $siswa->tgl_masuk) }}">
                                    @error('tgl_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body pt-4">
                            <h6 class="text-dark fw-bold border-bottom pb-2 mb-3">Data Orang Tua</h6>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nama_ayah" class="form-label fw-semibold">Nama Ayah <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ayah" id="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $orangTua->nama_ayah ?? '') }}" required>
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pekerjaan_ayah" class="form-label fw-semibold">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" value="{{ old('pekerjaan_ayah', $orangTua->pekerjaan_ayah ?? '') }}">
                                    @error('pekerjaan_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nomor_wa_ayah" class="form-label fw-semibold">No. Whatsapp Ayah</label>
                                    <input type="text" name="nomor_wa_ayah" id="nomor_wa_ayah" class="form-control @error('nomor_wa_ayah') is-invalid @enderror" value="{{ old('nomor_wa_ayah', $orangTua->nomor_wa ?? '') }}">
                                    @error('nomor_wa_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nama_ibu" class="form-label fw-semibold">Nama Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $orangTua->nama_ibu ?? '') }}" required>
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pekerjaan_ibu" class="form-label fw-semibold">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" value="{{ old('pekerjaan_ibu', $orangTua->pekerjaan_ibu ?? '') }}">
                                    @error('pekerjaan_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="nomor_wa_ibu" class="form-label fw-semibold">No. Whatsapp Ibu</label>
                                    <input type="text" name="nomor_wa_ibu" id="nomor_wa_ibu" class="form-control @error('nomor_wa_ibu') is-invalid @enderror" value="{{ old('nomor_wa_ibu', $orangTua->nomor_wa_ibu ?? '') }}">
                                    @error('nomor_wa_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="alamat_ortu" class="form-label fw-semibold">Alamat Orang Tua</label>
                                    <textarea name="alamat_ortu" id="alamat_ortu" rows="3" class="form-control @error('alamat_ortu') is-invalid @enderror">{{ old('alamat_ortu', $orangTua->alamat ?? '') }}</textarea>
                                    @error('alamat_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email_ortu" class="form-label fw-semibold">Email Orang Tua</label>
                                    <input type="email" name="email_ortu" id="email_ortu" class="form-control @error('email_ortu') is-invalid @enderror" value="{{ old('email_ortu', $orangTua->email ?? ($orangTua->user->email ?? '')) }}">
                                    @error('email_ortu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; font-weight: bold; border-radius: 8px;">
                                    <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
