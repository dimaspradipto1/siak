@extends('layouts.dashboard.template')

@section('title', 'Edit Kelas')

@section('content')
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark fs-4">Form Edit Kelas</h1>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" id="formEditKelas">
                            @csrf
                            @method('PUT')

                            {{-- Kode Kelas --}}
                            <div class="mb-3">
                                <label for="kode_kelas" class="form-label fw-medium text-secondary">Kode Kelas</label>
                                <input type="text" id="kode_kelas" name="kode_kelas"
                                    class="form-control rounded-3 @error('kode_kelas') is-invalid @enderror"
                                    value="{{ old('kode_kelas', $kelas->kode_kelas ?? ('KLS-' . str_pad($kelas->id, 2, '0', STR_PAD_LEFT))) }}"
                                    placeholder="Masukkan Kode Kelas">
                                @error('kode_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Kelas --}}
                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label fw-medium text-secondary">Nama Kelas</label>
                                <input type="text" id="nama_kelas" name="nama_kelas"
                                    class="form-control rounded-3 @error('nama_kelas') is-invalid @enderror"
                                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                                    placeholder="Masukkan Nama Kelas" required>
                                @error('nama_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tingkat --}}
                            <div class="mb-3">
                                <label for="tingkat" class="form-label fw-medium text-secondary">Tingkat</label>
                                <select id="tingkat" name="tingkat"
                                    class="form-select rounded-3 @error('tingkat') is-invalid @enderror" required>
                                    <option value="" disabled>-- Pilih Tingkat --</option>
                                    @foreach(['1', '2', '3', '4', '5', '6'] as $tingkat)
                                        <option value="{{ $tingkat }}" {{ old('tingkat', $kelas->tingkat) == $tingkat ? 'selected' : '' }}>Kelas {{ $tingkat }}</option>
                                    @endforeach
                                </select>
                                @error('tingkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ruangan --}}
                            <div class="mb-4">
                                <label for="ruangan" class="form-label fw-medium text-secondary">Ruangan</label>
                                <input type="text" id="ruangan" name="ruangan"
                                    class="form-control rounded-3 @error('ruangan') is-invalid @enderror"
                                    value="{{ old('ruangan', $kelas->ruangan) }}"
                                    placeholder="Masukkan Nama Ruangan" required>
                                @error('ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top">
                                <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2 rounded-3">
                                    Simpan Perubahan
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
