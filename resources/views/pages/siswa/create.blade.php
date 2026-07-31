@extends('layouts.dashboard.template')

@section('title', 'Tambah Data Siswa')

@section('content')
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark fs-4">Form Tambah Data Siswa</h1>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <form action="{{ route('siswa.store') }}" method="POST" id="formTambahSiswa">
                            @csrf
                            
                            <!-- ==========================================
                                 SECTION 1: DATA PRIBADI
                                 ========================================== -->
                            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Data Pribadi</h6>
                            
                            <div class="row g-3 mb-3">
                                {{-- NISN --}}
                                <div class="col-md-4">
                                    <label for="nisn" class="form-label fw-medium text-secondary">NISN</label>
                                    <input type="text" id="nisn" name="nisn" 
                                        class="form-control rounded-3 @error('nisn') is-invalid @enderror" 
                                        value="{{ old('nisn') }}" required placeholder="Masukkan NISN">
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Nama Lengkap --}}
                                <div class="col-md-4">
                                    <label for="nama_siswa" class="form-label fw-medium text-secondary">Nama Lengkap</label>
                                    <input type="text" id="nama_siswa" name="nama_siswa" 
                                        class="form-control rounded-3 @error('nama_siswa') is-invalid @enderror" 
                                        value="{{ old('nama_siswa') }}" required placeholder="Masukkan Nama Lengkap">
                                    @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label fw-medium text-secondary">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" 
                                        class="form-select rounded-3 @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                {{-- Tempat Lahir --}}
                                <div class="col-md-4">
                                    <label for="tempat_lahir" class="form-label fw-medium text-secondary">Tempat Lahir</label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" 
                                        class="form-control rounded-3 @error('tempat_lahir') is-invalid @enderror" 
                                        value="{{ old('tempat_lahir') }}" required placeholder="Kota Lahir">
                                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="col-md-4">
                                    <label for="tgl_lahir" class="form-label fw-medium text-secondary">Tanggal Lahir</label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" 
                                        class="form-control rounded-3 @error('tgl_lahir') is-invalid @enderror" 
                                        value="{{ old('tgl_lahir') }}" required>
                                    @error('tgl_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Agama --}}
                                <div class="col-md-4">
                                    <label for="agama" class="form-label fw-medium text-secondary">Agama</label>
                                    <select id="agama" name="agama" 
                                        class="form-select rounded-3 @error('agama') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                            <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                        @endforeach
                                    </select>
                                    @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                {{-- Whatsapp --}}
                                <div class="col-md-4">
                                    <label for="nomor_wa" class="form-label fw-medium text-secondary">Whatsapp</label>
                                    <input type="text" id="nomor_wa" name="nomor_wa" 
                                        class="form-control rounded-3 @error('nomor_wa') is-invalid @enderror" 
                                        value="{{ old('nomor_wa') }}" placeholder="Nomor WA Siswa">
                                    @error('nomor_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-medium text-secondary">Status</label>
                                    <select id="status" name="status" 
                                        class="form-select rounded-3 @error('status') is-invalid @enderror">
                                        <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Pindah" {{ old('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4">
                                    <label for="email_siswa" class="form-label fw-medium text-secondary">Email</label>
                                    <input type="email" id="email_siswa" name="email_siswa" 
                                        class="form-control rounded-3 @error('email_siswa') is-invalid @enderror" 
                                        value="{{ old('email_siswa') }}" placeholder="Email Siswa">
                                    @error('email_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                {{-- Alamat Lengkap --}}
                                <div class="col-md-3">
                                    <label for="alamat" class="form-label fw-medium text-secondary">Alamat Lengkap</label>
                                    <textarea id="alamat" name="alamat" rows="2" 
                                        class="form-control rounded-3 @error('alamat') is-invalid @enderror" 
                                        placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>
                                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Password --}}
                                <div class="col-md-3">
                                    <label for="password_siswa" class="form-label fw-medium text-secondary">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_siswa" name="password_siswa" 
                                            class="form-control rounded-start-3 @error('password_siswa') is-invalid @enderror" 
                                            value="{{ old('password_siswa') }}"
                                            placeholder="Password Akun Siswa">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_siswa">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_siswa')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-md-3">
                                    <label for="password_siswa_confirmation" class="form-label fw-medium text-secondary">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_siswa_confirmation" name="password_siswa_confirmation" 
                                            class="form-control rounded-start-3" 
                                            value="{{ old('password_siswa_confirmation') }}"
                                            placeholder="Ulangi Password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_siswa_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Tanggal Masuk --}}
                                <div class="col-md-3">
                                    <label for="tgl_masuk" class="form-label fw-medium text-secondary">Tanggal Masuk</label>
                                    <input type="date" id="tgl_masuk" name="tgl_masuk" 
                                        class="form-control rounded-3 @error('tgl_masuk') is-invalid @enderror" 
                                        value="{{ old('tgl_masuk', date('Y-m-d')) }}">
                                    @error('tgl_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- ==========================================
                                 SECTION 2: DATA ORANG TUA
                                 ========================================== -->
                            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2 pt-3">Data Orang Tua</h6>

                            <div class="row g-3 mb-3">
                                {{-- Nama Ayah --}}
                                <div class="col-md-4">
                                    <label for="nama_ayah" class="form-label fw-medium text-secondary">Nama Ayah</label>
                                    <input type="text" id="nama_ayah" name="nama_ayah" 
                                        class="form-control rounded-3 @error('nama_ayah') is-invalid @enderror" 
                                        value="{{ old('nama_ayah') }}" placeholder="Nama Ayah">
                                    @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Pekerjaan Ayah --}}
                                <div class="col-md-4">
                                    <label for="pekerjaan_ayah" class="form-label fw-medium text-secondary">Pekerjaan Ayah</label>
                                    <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" 
                                        class="form-control rounded-3 @error('pekerjaan_ayah') is-invalid @enderror" 
                                        value="{{ old('pekerjaan_ayah') }}" placeholder="Pekerjaan Ayah">
                                    @error('pekerjaan_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- No. Whatsapp Ayah --}}
                                <div class="col-md-4">
                                    <label for="nomor_wa_ayah" class="form-label fw-medium text-secondary">No. Whatsapp Ayah</label>
                                    <input type="text" id="nomor_wa_ayah" name="nomor_wa_ayah" 
                                        class="form-control rounded-3 @error('nomor_wa_ayah') is-invalid @enderror" 
                                        value="{{ old('nomor_wa_ayah') }}" placeholder="No. WA Ayah">
                                    @error('nomor_wa_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                {{-- Nama Ibu --}}
                                <div class="col-md-4">
                                    <label for="nama_ibu" class="form-label fw-medium text-secondary">Nama Ibu</label>
                                    <input type="text" id="nama_ibu" name="nama_ibu" 
                                        class="form-control rounded-3 @error('nama_ibu') is-invalid @enderror" 
                                        value="{{ old('nama_ibu') }}" placeholder="Nama Ibu">
                                    @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Pekerjaan Ibu --}}
                                <div class="col-md-4">
                                    <label for="pekerjaan_ibu" class="form-label fw-medium text-secondary">Pekerjaan Ibu</label>
                                    <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" 
                                        class="form-control rounded-3 @error('pekerjaan_ibu') is-invalid @enderror" 
                                        value="{{ old('pekerjaan_ibu') }}" placeholder="Pekerjaan Ibu">
                                    @error('pekerjaan_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- No. Whatsapp Ibu --}}
                                <div class="col-md-4">
                                    <label for="nomor_wa_ibu" class="form-label fw-medium text-secondary">No. Whatsapp Ibu</label>
                                    <input type="text" id="nomor_wa_ibu" name="nomor_wa_ibu" 
                                        class="form-control rounded-3 @error('nomor_wa_ibu') is-invalid @enderror" 
                                        value="{{ old('nomor_wa_ibu') }}" placeholder="No. WA Ibu">
                                    @error('nomor_wa_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                {{-- Alamat Orang Tua --}}
                                <div class="col-md-4">
                                    <label for="alamat_ortu" class="form-label fw-medium text-secondary">Alamat Orang Tua</label>
                                    <textarea id="alamat_ortu" name="alamat_ortu" rows="2" 
                                        class="form-control rounded-3 @error('alamat_ortu') is-invalid @enderror" 
                                        placeholder="Alamat Orang Tua">{{ old('alamat_ortu') }}</textarea>
                                    @error('alamat_ortu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4">
                                    <label for="email_ortu" class="form-label fw-medium text-secondary">Email</label>
                                    <input type="email" id="email_ortu" name="email_ortu" 
                                        class="form-control rounded-3 @error('email_ortu') is-invalid @enderror" 
                                        value="{{ old('email_ortu') }}" placeholder="Email Orang Tua">
                                    @error('email_ortu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                {{-- Password Baru --}}
                                <div class="col-md-4">
                                    <label for="password_ortu" class="form-label fw-medium text-secondary">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="password_ortu" name="password_ortu" 
                                            class="form-control rounded-start-3 @error('password_ortu') is-invalid @enderror" 
                                            value="{{ old('password_ortu') }}"
                                            placeholder="Password Akun Orang Tua">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_ortu">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_ortu')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                {{-- Role --}}
                                <div class="col-md-4">
                                    <label for="role_ortu" class="form-label fw-medium text-secondary">Role</label>
                                    <input type="text" id="role_ortu" class="form-control rounded-3 bg-light" value="Orang Tua" readonly disabled>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4">
                                    <label for="status_ortu" class="form-label fw-medium text-secondary">Status</label>
                                    <select id="status_ortu" name="status_ortu" class="form-select rounded-3">
                                        <option value="Aktif" selected>Aktif</option>
                                        <option value="Non-Aktif">Non-Aktif</option>
                                    </select>
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-md-4">
                                    <label for="password_ortu_confirmation" class="form-label fw-medium text-secondary">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_ortu_confirmation" name="password_ortu_confirmation" 
                                            class="form-control rounded-start-3" 
                                            value="{{ old('password_ortu_confirmation') }}"
                                            placeholder="Ulangi Password">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_ortu_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ==========================================
                                 FOOTER BUTTONS
                                 ========================================== -->
                            <div class="d-flex justify-content-end align-items-center gap-2 pt-3">
                                <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
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
        $(document).on('click', '.toggle-password', function () {
            const targetId = $(this).data('target');
            const input = $('#' + targetId);
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

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
