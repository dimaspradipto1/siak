@extends('layouts.dashboard.template')

@section('title', 'Materi Pembelajaran')

@section('content')
    <div class="pagetitle">
        <h1>Materi Pembelajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Materi Pembelajaran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 pb-3">
                    <div class="card-body pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title text-dark fw-bold mb-0">
                                {{ in_array(auth()->user()->roles, ['siswa', 'orang tua']) ? 'Daftar Materi Pembelajaran Siswa' : 'Daftar Materi Pembelajaran' }}
                            </h5>
                            @if(!in_array(auth()->user()->roles, ['siswa', 'orang tua']))
                            <a href="{{ route('materipembelajaran.create') }}" class="btn btn-dark btn-sm px-3" style="background-color: #212529; border-color: #212529;">
                                <i class="bi bi-plus-circle-fill"></i> Tambah Data
                            </a>
                            @endif
                        </div>

                        <!-- Filter Form -->
                        <form id="filterForm" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="tahun_ajaran_id" class="form-label fw-semibold text-dark">Tahun Ajaran</label>
                                    <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select select2-filter">
                                        <option value="">Semua Tahun Ajaran</option>
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}">
                                                {{ $ta->nama_tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="semester_name" class="form-label fw-semibold text-dark">Semester</label>
                                    <select id="semester_name" name="semester_name" class="form-select select2-filter">
                                        <option value="">Semua Semester</option>
                                        <option value="Semester 1 (Ganjil)">Semester 1 (Ganjil)</option>
                                        <option value="Semester 2 (Genap)">Semester 2 (Genap)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="kelas_id" class="form-label fw-semibold text-dark">Kelas</label>
                                    <select id="kelas_id" name="kelas_id" class="form-select select2-filter">
                                        @if(!in_array(auth()->user()->roles, ['siswa', 'orang tua']))
                                            <option value="">Semua Kelas</option>
                                        @endif
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="nama_mata_pelajaran" class="form-label fw-semibold text-dark">Mata Pelajaran</label>
                                    <select id="nama_mata_pelajaran" name="nama_mata_pelajaran" class="form-select select2-filter">
                                        <option value="">Semua Mata Pelajaran</option>
                                        @foreach($uniqueMapels as $name)
                                            <option value="{{ $name }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Tampilkan Data
                                </button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-bordered table-hover align-middle', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
    <script>
        // Draw datatable when filter form submitted
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            window.LaravelDataTables["materipembelajaran-table"].draw();
        });

        // SweetAlert Confirmation for Delete
        $(document).on('click', '.btn-hapus', function (e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Materi Pelajaran?',
                html: `Anda yakin ingin menghapus materi:<br><strong class="text-danger">${nama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill"></i> Ya, Hapus!',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({title: 'Menghapus...', allowOutsideClick: false, didOpen: () => {Swal.showLoading()}});
                    form.submit();
                }
            });
        });
    </script>
@endpush
