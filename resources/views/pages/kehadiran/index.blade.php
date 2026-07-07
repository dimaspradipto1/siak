@extends('layouts.dashboard.template')

@section('title', 'Rekap Kehadiran')

@section('content')
    <div class="pagetitle d-print-none">
        <h1 class="text-primary fw-bold">Rekap Kehadiran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekap Kehadiran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- Filter Form Card -->
                <div class="card shadow-sm border-0 mb-4 d-print-none">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary fw-bold p-0 mb-0">Form Rekap Kehadiran</h5>
                            @if(!in_array(auth()->user()->roles, ['siswa', 'orang tua']))
                                <a href="{{ route('kehadiran.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle-fill"></i> Input Kehadiran
                                </a>
                            @endif
                        </div>
                        
                        <form id="filterForm" action="{{ route('kehadiran.index') }}" method="GET" class="row g-3">
                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
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
                                
                                <div class="col-md-6">
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
                            </div>

                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
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

                                <div class="col-md-6">
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
                            </div>

                            <div class="row mb-3 g-3">
                                <div class="col-md-6">
                                    <label for="bulan" class="form-label fw-semibold">Bulan <span class="text-danger">*</span></label>
                                    <select name="bulan" id="bulan" class="form-select select2" required>
                                        <option value="" disabled selected>-- Pilih Bulan --</option>
                                        @php
                                            $monthsList = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                        @endphp
                                        @foreach($monthsList as $num => $name)
                                            <option value="{{ $num }}" {{ $selectedBulan == $num ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-3 pt-2">
                                <a href="{{ route('kehadiran.index') }}" class="btn btn-link text-secondary text-decoration-none px-3 align-self-center">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="border-radius: 8px;">
                                    Tampilkan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recap Grid Results -->
                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel && $selectedBulan)
                <div class="card shadow-sm border-0 print-card">
                    <div class="card-body pt-4">
                        <!-- Print Heading Header Info -->
                        <div class="d-none d-print-block text-center mb-4">
                            <h3 class="fw-bold">REKAPITULASI KEHADIRAN SISWA</h3>
                            <h5 class="text-secondary">SD Negeri 007 Sekupang</h5>
                            <div class="row mt-3 text-start mx-auto" style="max-width: 600px; font-size: 0.9rem;">
                                <div class="col-6 mb-1"><strong>Mata Pelajaran:</strong> {{ $selectedMapelModel->nama_mata_pelajaran ?? '-' }}</div>
                                <div class="col-6 mb-1"><strong>Kelas:</strong> {{ $selectedKelasModel->nama_kelas ?? '-' }}</div>
                                <div class="col-6 mb-1"><strong>Bulan:</strong> {{ $monthsList[$selectedBulan] ?? '-' }}</div>
                                <div class="col-6 mb-1"><strong>Tahun Ajaran:</strong> {{ $selectedMapelModel->tahunAjaran->nama_tahun_ajaran ?? '-' }} ({{ $selectedMapelModel->semester->nama_semester ?? '-' }})</div>
                            </div>
                            <hr style="border-top: 2px solid #000;">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
                            <h5 class="card-title text-primary fw-bold p-0 mb-0">Tabel Rekap Kehadiran</h5>
                            <button type="button" class="btn btn-dark btn-sm px-3" onclick="window.print()" style="border-radius: 6px;">
                                <i class="bi bi-printer"></i> Cetak
                            </button>
                        </div>

                        @if(count($students) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center" style="font-size: 0.85rem;">
                                    <thead class="table-light fw-bold text-dark">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th style="width: 120px;">NISN</th>
                                            <th class="text-start" style="width: 250px;">Nama Siswa</th>
                                            @if(count($dates) > 0)
                                                @foreach($dates as $date)
                                                    <th style="width: 45px;">
                                                        {{ \Carbon\Carbon::parse($date)->format('d') }}
                                                    </th>
                                                @endforeach
                                            @else
                                                <th>Belum ada data kehadiran</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td class="text-start fw-semibold">{{ $siswa->nama_siswa }}</td>
                                                
                                                @if(count($dates) > 0)
                                                    @foreach($dates as $date)
                                                        @php
                                                            $code = $siswa->attendance_map[$date] ?? '';
                                                            $badgeClass = '';
                                                            if ($code === 'H') $badgeClass = 'text-success fw-bold';
                                                            elseif ($code === 'S') $badgeClass = 'text-warning fw-bold';
                                                            elseif ($code === 'I') $badgeClass = 'text-primary fw-bold';
                                                            elseif ($code === 'A') $badgeClass = 'text-danger fw-bold';
                                                        @endphp
                                                        <td class="{{ $badgeClass }}">
                                                            {{ $code ?: '-' }}
                                                        </td>
                                                    @endforeach
                                                @else
                                                    <td class="text-muted italic">-</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Print button at bottom right (hidden when printing) -->
                            <div class="d-flex justify-content-end mt-4 d-print-none">
                                <button type="button" class="btn btn-dark px-4 py-2" onclick="window.print()" style="border-radius: 8px;">
                                    Cetak
                                </button>
                            </div>
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
        /* Custom print stylesheet overrides */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            /* Hide dashboard decorations */
            .header, #sidebar, .sidebar, .pagetitle, .d-print-none, hr.mb-4 {
                display: none !important;
            }
            /* Reset main container spacing */
            #main, .main {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
            /* Remove card shadow and border for print */
            .print-card {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
            }
            .table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-top: 15px;
            }
            .table th, .table td {
                border: 1px solid #000000 !important;
                color: #000000 !important;
                padding: 6px 4px !important;
            }
            .table-light {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
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
