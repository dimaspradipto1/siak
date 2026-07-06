@extends('layouts.dashboard.template')

@section('title', 'Edit Profil Sekolah')

@section('content')
    <div class="pagetitle">
        <h1>Edit Profil Sekolah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-sekolah.index') }}">Profil Sekolah</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white"
                                style="width:42px;height:42px;background:linear-gradient(135deg,#e0a800,#ffc107);">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-warning">Form Edit Profil Sekolah</h5>
                        </div>

                        <form action="{{ route('profil-sekolah.update', $profil_sekolah->id) }}" method="POST" enctype="multipart/form-data" id="formEdit">
                            @csrf
                            @method('PUT')

                            <!-- Section: Informasi Umum -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-secondary">Informasi Umum</h6>
                                
                                <div class="row">
                                    {{-- Nama Sekolah --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" id="nama_sekolah" name="nama_sekolah"
                                            class="form-control @error('nama_sekolah') is-invalid @enderror"
                                            value="{{ old('nama_sekolah', $profil_sekolah->nama_sekolah) }}" required placeholder="Nama Sekolah">
                                        @error('nama_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NIS/NSS/NDS --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="nis_nss_nds" class="form-label fw-semibold">NIS/NSS/NDS</label>
                                        <input type="text" id="nis_nss_nds" name="nis_nss_nds"
                                            class="form-control @error('nis_nss_nds') is-invalid @enderror"
                                            value="{{ old('nis_nss_nds', $profil_sekolah->nis_nss_nds) }}" placeholder="NIS/NSS/NDS">
                                        @error('nis_nss_nds')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Nama Kepala Sekolah --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="nama_kepala_sekolah" class="form-label fw-semibold">Nama Kepala Sekolah</label>
                                        <input type="text" id="nama_kepala_sekolah" name="nama_kepala_sekolah"
                                            class="form-control @error('nama_kepala_sekolah') is-invalid @enderror"
                                            value="{{ old('nama_kepala_sekolah', $profil_sekolah->nama_kepala_sekolah) }}" placeholder="Nama Kepala Sekolah">
                                        @error('nama_kepala_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NIP Kepala Sekolah --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="nip_kepala_sekolah" class="form-label fw-semibold">NIP Kepala Sekolah</label>
                                        <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah"
                                            class="form-control @error('nip_kepala_sekolah') is-invalid @enderror"
                                            value="{{ old('nip_kepala_sekolah', $profil_sekolah->nip_kepala_sekolah) }}" placeholder="NIP Kepala Sekolah">
                                        @error('nip_kepala_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Alamat Sekolah --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="alamat_sekolah" class="form-label fw-semibold">Alamat Sekolah</label>
                                        <input type="text" id="alamat_sekolah" name="alamat_sekolah"
                                            class="form-control @error('alamat_sekolah') is-invalid @enderror"
                                            value="{{ old('alamat_sekolah', $profil_sekolah->alamat_sekolah) }}" placeholder="Alamat Sekolah">
                                        @error('alamat_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Kelurahan/Desa --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="kelurahan_desa" class="form-label fw-semibold">Kelurahan/Desa</label>
                                        <input type="text" id="kelurahan_desa" name="kelurahan_desa"
                                            class="form-control @error('kelurahan_desa') is-invalid @enderror"
                                            value="{{ old('kelurahan_desa', $profil_sekolah->kelurahan_desa) }}" placeholder="Kelurahan/Desa">
                                        @error('kelurahan_desa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Kecamatan --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                        <input type="text" id="kecamatan" name="kecamatan"
                                            class="form-control @error('kecamatan') is-invalid @enderror"
                                            value="{{ old('kecamatan', $profil_sekolah->kecamatan) }}" placeholder="Kecamatan">
                                        @error('kecamatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Kabupaten/Kota --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="kabupaten_kota" class="form-label fw-semibold">Kabupaten/Kota</label>
                                        <input type="text" id="kabupaten_kota" name="kabupaten_kota"
                                            class="form-control @error('kabupaten_kota') is-invalid @enderror"
                                            value="{{ old('kabupaten_kota', $profil_sekolah->kabupaten_kota) }}" placeholder="Kabupaten/Kota">
                                        @error('kabupaten_kota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Provinsi --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                        <input type="text" id="provinsi" name="provinsi"
                                            class="form-control @error('provinsi') is-invalid @enderror"
                                            value="{{ old('provinsi', $profil_sekolah->provinsi) }}" placeholder="Provinsi">
                                        @error('provinsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Kode Pos --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="kode_pos" class="form-label fw-semibold">Kode Pos</label>
                                        <input type="text" id="kode_pos" name="kode_pos"
                                            class="form-control @error('kode_pos') is-invalid @enderror"
                                            value="{{ old('kode_pos', $profil_sekolah->kode_pos) }}" placeholder="Kode Pos">
                                        @error('kode_pos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Berdiri --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="tanggal_berdiri" class="form-label fw-semibold">Tanggal Berdiri</label>
                                        <input type="date" id="tanggal_berdiri" name="tanggal_berdiri"
                                            class="form-control @error('tanggal_berdiri') is-invalid @enderror"
                                            value="{{ old('tanggal_berdiri', $profil_sekolah->tanggal_berdiri) }}">
                                        @error('tanggal_berdiri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tahun Ajaran --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran</label>
                                        <select id="tahun_ajaran_id" name="tahun_ajaran_id"
                                            class="form-select @error('tahun_ajaran_id') is-invalid @enderror">
                                            <option value="">-- Pilih Tahun Ajaran --</option>
                                            @foreach ($tahunAjarans as $ta)
                                                <option value="{{ $ta->id }}" 
                                                    {{ old('tahun_ajaran_id', $profil_sekolah->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                                    {{ $ta->nama_tahun_ajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tahun_ajaran_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- No. Telephone --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="no_telephone" class="form-label fw-semibold">No. Telephone</label>
                                        <input type="text" id="no_telephone" name="no_telephone"
                                            class="form-control @error('no_telephone') is-invalid @enderror"
                                            value="{{ old('no_telephone', $profil_sekolah->no_telephone) }}" placeholder="No. Telephone">
                                        @error('no_telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $profil_sekolah->email) }}" placeholder="Email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-3 mb-3">
                                        <label for="status" class="form-label fw-semibold">Status</label>
                                        <select id="status" name="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Negeri" {{ old('status', $profil_sekolah->status) === 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                            <option value="Swasta" {{ old('status', $profil_sekolah->status) === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Logo Sekolah -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-secondary">Logo Sekolah</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="logo_sekolah" class="form-label fw-semibold">Upload Logo Baru</label>
                                        <input type="file" id="logo_sekolah" name="logo_sekolah" accept="image/*"
                                            class="form-control @error('logo_sekolah') is-invalid @enderror"
                                            onchange="previewImage(event)">
                                        <div class="form-text">Format: JPEG, PNG, JPG, GIF, WebP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah logo.</div>
                                        @error('logo_sekolah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3 d-flex flex-column align-items-start">
                                        <span class="fw-semibold mb-2">Pratinjau Logo</span>
                                        <div class="border rounded d-flex align-items-center justify-content-center bg-light" 
                                            style="width: 150px; height: 150px; overflow: hidden;">
                                            @if ($profil_sekolah->logo_sekolah)
                                                <img id="logo_preview" src="{{ asset($profil_sekolah->logo_sekolah) }}" alt="Pratinjau Logo" 
                                                    class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                                <div id="logo_placeholder" class="text-muted text-center p-2 d-none">
                                                    <i class="bi bi-image fs-1 d-block mb-1"></i>
                                                    <small>Belum ada logo</small>
                                                </div>
                                            @else
                                                <img id="logo_preview" src="" alt="Pratinjau Logo" 
                                                    class="img-fluid d-none" style="max-height: 100%; object-fit: contain;">
                                                <div id="logo_placeholder" class="text-muted text-center p-2">
                                                    <i class="bi bi-image fs-1 d-block mb-1"></i>
                                                    <small>Belum ada logo</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Informasi Lainnya -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-secondary">Informasi Lainnya</h6>
                                
                                <div class="row">
                                    {{-- Deskripsi --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                            class="form-control @error('deskripsi') is-invalid @enderror"
                                            placeholder="Visi, Misi, atau deskripsi singkat sekolah">{{ old('deskripsi', $profil_sekolah->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('profil-sekolah.index') }}" class="btn btn-secondary">
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('logo_preview');
                const placeholder = document.getElementById('logo_placeholder');
                output.src = reader.result;
                output.classList.remove('d-none');
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

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
