@extends('layouts.dashboard.template')

@section('title', 'Input Kehadiran')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Input Kehadiran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kehadiran.index') }}">Kehadiran</a></li>
                <li class="breadcrumb-item active">Input Kehadiran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Input Kehadiran</h5>
                        
                        <form id="filterForm" action="{{ route('kehadiran.create') }}" method="GET" class="row g-3">
                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select select2" required>
                                        <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                        @foreach($tahunAjarans as $ta)
                                            <option value="{{ $ta->id }}" {{ $selectedTa == $ta->id ? 'selected' : '' }}>
                                                {{ $ta->nama_tahun_ajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                    <select name="semester_id" id="semester_id" class="form-select select2" required>
                                        <option value="" disabled selected>-- Pilih Semester --</option>
                                        @foreach($semesters as $sem)
                                            <option value="{{ $sem->id }}" {{ $selectedSem == $sem->id ? 'selected' : '' }}>
                                                {{ $sem->nama_semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <select name="kelas_id" id="kelas_id" class="form-select select2" required>
                                        <option value="" disabled selected>-- Pilih Kelas --</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select select2" required>
                                        <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                        @foreach($mapels as $mp)
                                            <option value="{{ $mp->id }}" {{ $selectedMapel == $mp->id ? 'selected' : '' }}>
                                                {{ $mp->nama_mata_pelajaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal" class="form-label fw-semibold">Tanggal Kehadiran <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $selectedTanggal }}" required>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-3 pt-2">
                                <a href="{{ route('kehadiran.create') }}" class="btn btn-link text-secondary text-decoration-none px-3 align-self-center">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="border-radius: 8px;">
                                    Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel && $selectedTanggal)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <hr class="mb-4" style="border-top: 1px solid #e9ecef; opacity: 1;">
                        
                        @if(count($students) > 0)
                        <form action="{{ route('kehadiran.save') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tahun_ajaran_id" value="{{ $selectedTa }}">
                            <input type="hidden" name="semester_id" value="{{ $selectedSem }}">
                            <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedMapel }}">
                            <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">

                            @php
                                $jkHadir = $jenisKehadirans->where('kode_kehadiran', 'H')->first();
                                $jkSakit = $jenisKehadirans->where('kode_kehadiran', 'S')->first();
                                $jkIzin = $jenisKehadirans->where('kode_kehadiran', 'I')->first();
                                $jkAlpa = $jenisKehadirans->where('kode_kehadiran', 'A')->first();
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle" style="min-width: 1000px;">
                                    <thead class="table-light fw-bold text-dark text-center">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th style="width: 130px;">NISN</th>
                                            <th class="text-start" style="width: 250px;">Nama Siswa</th>
                                            <th style="width: 80px;">Hadir</th>
                                            <th style="width: 80px;">Sakit</th>
                                            <th style="width: 80px;">Izin</th>
                                            <th style="width: 80px;">Alpa</th>
                                            <th style="width: 180px;">Jenis Catatan</th>
                                            <th>Catatan Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $index => $siswa)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $siswa->nisn }}</td>
                                                <td class="fw-semibold text-start">{{ $siswa->nama_siswa }}</td>
                                                
                                                <!-- Hadir -->
                                                <td class="text-center">
                                                    <input class="attendance-radio" type="radio" 
                                                           name="kehadiran[{{ $siswa->id }}]" 
                                                           id="attendance_{{ $siswa->id }}_H" 
                                                           value="{{ $jkHadir?->id }}"
                                                           {{ ($siswa->kehadiran_record?->jenis_kehadiran_id == $jkHadir?->id) || (!$siswa->kehadiran_record && $jkHadir) ? 'checked' : '' }} required>
                                                </td>

                                                <!-- Sakit -->
                                                <td class="text-center">
                                                    <input class="attendance-radio" type="radio" 
                                                           name="kehadiran[{{ $siswa->id }}]" 
                                                           id="attendance_{{ $siswa->id }}_S" 
                                                           value="{{ $jkSakit?->id }}"
                                                           {{ $siswa->kehadiran_record?->jenis_kehadiran_id == $jkSakit?->id ? 'checked' : '' }}>
                                                </td>

                                                <!-- Izin -->
                                                <td class="text-center">
                                                    <input class="attendance-radio" type="radio" 
                                                           name="kehadiran[{{ $siswa->id }}]" 
                                                           id="attendance_{{ $siswa->id }}_I" 
                                                           value="{{ $jkIzin?->id }}"
                                                           {{ $siswa->kehadiran_record?->jenis_kehadiran_id == $jkIzin?->id ? 'checked' : '' }}>
                                                </td>

                                                <!-- Alpa -->
                                                <td class="text-center">
                                                    <input class="attendance-radio" type="radio" 
                                                           name="kehadiran[{{ $siswa->id }}]" 
                                                           id="attendance_{{ $siswa->id }}_A" 
                                                           value="{{ $jkAlpa?->id }}"
                                                           {{ $siswa->kehadiran_record?->jenis_kehadiran_id == $jkAlpa?->id ? 'checked' : '' }}>
                                                </td>

                                                <!-- Jenis Catatan -->
                                                <td>
                                                    <select name="jenis_catatan_id[{{ $siswa->id }}]" class="form-select form-select-sm" style="border-radius: 6px; border: 1px solid #ced4da;">
                                                        <option value="">-- Pilih Catatan --</option>
                                                        @foreach($jenisCatatans as $jc)
                                                            <option value="{{ $jc->id }}" {{ $siswa->catatan_record?->jenis_catatan_id == $jc->id ? 'selected' : '' }}>
                                                                {{ $jc->nama_jenis_catatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <!-- Catatan Kehadiran -->
                                                <td>
                                                    <input type="text" name="keterangan[{{ $siswa->id }}]" class="form-control form-control-sm" style="border-radius: 6px; border: 1px solid #ced4da;" 
                                                           value="{{ $siswa->catatan_record?->isi_catatan ?? $siswa->kehadiran_record?->keterangan ?? '' }}" placeholder="Catatan Kehadiran">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Kehadiran</button>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data siswa ditemukan untuk kelas ini.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        /* Custom radio styling for attendance */
        .attendance-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #212529;
            border-radius: 6px !important;
            outline: none;
            transition: all 0.2s ease-in-out;
            position: relative;
            cursor: pointer;
            vertical-align: middle;
            margin: 0 auto;
            display: block;
        }

        .attendance-radio:checked {
            background-color: #212529;
            border-color: #212529;
        }

        .attendance-radio:checked::after {
            content: '\2713'; /* Unicode checkmark */
            font-size: 14px;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .attendance-radio:hover {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.2);
        }
    </style>
@endsection

@push('script')
<script>
$(document).ready(function() {
    function loadKelasDanMapel(selectedKelasId = null, selectedMapelId = null) {
        const taId = $('#tahun_ajaran_id').val();
        const semId = $('#semester_id').val();
        if (!taId || !semId) return;

        $.ajax({
            url: "{{ route('kehadiran.get-kelas-mapel') }}",
            type: "GET",
            data: {
                tahun_ajaran_id: taId,
                semester_id: semId
            },
            success: function(response) {
                // Update Kelas select
                const kelasSelect = $('#kelas_id');
                const currKelas = selectedKelasId || "{{ $selectedKelas }}";
                kelasSelect.empty().append('<option value="" disabled selected>-- Pilih Kelas --</option>');
                response.kelas.forEach(function(k) {
                    const selected = currKelas == k.id ? 'selected' : '';
                    kelasSelect.append(`<option value="${k.id}" ${selected}>${k.nama_kelas}</option>`);
                });

                // Update Mata Pelajaran select
                const mapelSelect = $('#mata_pelajaran_id');
                const currMapel = selectedMapelId || "{{ $selectedMapel }}";
                mapelSelect.empty().append('<option value="" disabled selected>-- Pilih Mata Pelajaran --</option>');
                response.mapels.forEach(function(m) {
                    const selected = currMapel == m.id ? 'selected' : '';
                    mapelSelect.append(`<option value="${m.id}" ${selected}>${m.nama_mata_pelajaran}</option>`);
                });
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }

    // Trigger on change of Tahun Ajaran or Semester
    $('#tahun_ajaran_id, #semester_id').on('change', function() {
        loadKelasDanMapel();
    });

    // Run once on load if values exist
    if ($('#tahun_ajaran_id').val() && $('#semester_id').val()) {
        loadKelasDanMapel("{{ $selectedKelas }}", "{{ $selectedMapel }}");
    }
});
</script>
@endpush
