@extends('layouts.dashboard.template')

@section('title', 'Edit Tahun Ajaran')

@section('content')
    <div class="pagetitle">
        <h1>Edit Tahun Ajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a></li>
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
                            <h5 class="mb-0">Form Edit Tahun Ajaran</h5>
                        </div>

                        <form action="{{ route('tahun-ajaran.update', $tahun_ajaran->id) }}" method="POST" id="formEdit">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Tahun Mulai --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tahun_mulai" class="form-label fw-semibold">
                                        Tahun Mulai <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="number" id="tahun_mulai" name="tahun_mulai"
                                            class="form-control @error('tahun_mulai') is-invalid @enderror"
                                            value="{{ old('tahun_mulai', $tahun_ajaran->tahun_mulai) }}"
                                            placeholder="Contoh: 2024"
                                            min="2000" max="2099">
                                        @error('tahun_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tahun Selesai --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tahun_selesai" class="form-label fw-semibold">
                                        Tahun Selesai <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                        <input type="number" id="tahun_selesai" name="tahun_selesai"
                                            class="form-control @error('tahun_selesai') is-invalid @enderror"
                                            value="{{ old('tahun_selesai', $tahun_ajaran->tahun_selesai) }}"
                                            placeholder="Contoh: 2025"
                                            min="2000" max="2099" readonly>
                                        @error('tahun_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text text-muted">
                                        Otomatis terisi (tahun mulai + 1).
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="Aktif" {{ old('status', $tahun_ajaran->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $tahun_ajaran->status) === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Jika diset <strong>Aktif</strong>, tahun ajaran lain yang aktif akan otomatis dinonaktifkan.
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="{{ route('tahun-ajaran.index') }}" class="btn btn-secondary">
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
        // Auto-fill Tahun Selesai saat mengisi Tahun Mulai
        document.getElementById('tahun_mulai').addEventListener('input', function() {
            const tahunMulai = parseInt(this.value);
            const tahunSelesaiInput = document.getElementById('tahun_selesai');
            if (!isNaN(tahunMulai) && this.value.length === 4) {
                tahunSelesaiInput.value = tahunMulai + 1;
            } else {
                tahunSelesaiInput.value = '';
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
