@extends('layouts.dashboard.template')

@section('title', 'Edit Siswa')

@section('content')
    <div class="pagetitle">
        <h1>Edit Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <h5 class="card-title mt-0">Data Pribadi</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nisn" class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
                                    <input type="text" id="nisn" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $siswa->nisn) }}">
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="nama_siswa" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" id="nama_siswa" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
                                    @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir', $siswa->tgl_lahir) }}">
                                    @error('tgl_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="agama" class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                                    <select id="agama" name="agama" class="form-select @error('agama') is-invalid @enderror">
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                            <option value="{{ $agm }}" {{ old('agama', $siswa->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="nomor_wa" class="form-label fw-semibold">Nomor WA / HP</label>
                                    <input type="text" id="nomor_wa" name="nomor_wa" class="form-control @error('nomor_wa') is-invalid @enderror" value="{{ old('nomor_wa', $siswa->nomor_wa) }}">
                                    @error('nomor_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="status" class="form-label fw-semibold">Status Siswa</label>
                                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="Aktif" {{ old('status', $siswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Lulus" {{ old('status', $siswa->status) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Pindah" {{ old('status', $siswa->status) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <hr>
                            <h5 class="card-title mt-0">Data Akademik & Relasi</h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <select id="kelas_id" name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="orang_tua_id" class="form-label fw-semibold">Orang Tua / Wali <span class="text-danger">*</span></label>
                                    <select id="orang_tua_id" name="orang_tua_id" class="form-select @error('orang_tua_id') is-invalid @enderror">
                                        @foreach($orangTuas as $ot)
                                            <option value="{{ $ot->id }}" {{ old('orang_tua_id', $siswa->orang_tua_id) == $ot->id ? 'selected' : '' }}>{{ $ot->nama_ayah ?? $ot->nama_ibu ?? 'Wali' }}</option>
                                        @endforeach
                                    </select>
                                    @error('orang_tua_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="ekstrakurikuler_id" class="form-label fw-semibold">Ekstrakurikuler (Opsional)</label>
                                    <select id="ekstrakurikuler_id" name="ekstrakurikuler_id" class="form-select @error('ekstrakurikuler_id') is-invalid @enderror">
                                        <option value="" selected>-- Tidak Ada / Belum Pilih --</option>
                                        @foreach($ekstrakurikulers as $ekskul)
                                            <option value="{{ $ekskul->id }}" {{ old('ekstrakurikuler_id', $siswa->ekstrakurikuler_id) == $ekskul->id ? 'selected' : '' }}>{{ $ekskul->nama_ekskul }}</option>
                                        @endforeach
                                    </select>
                                    @error('ekstrakurikuler_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label for="tgl_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                                    <input type="date" id="tgl_masuk" name="tgl_masuk" class="form-control @error('tgl_masuk') is-invalid @enderror" value="{{ old('tgl_masuk', $siswa->tgl_masuk) }}">
                                    @error('tgl_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
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
