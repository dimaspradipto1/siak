@extends('layouts.dashboard.template')

@section('title', 'Input Nilai Raport')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Input Nilai Raport</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">Nilai</a></li>
                <li class="breadcrumb-item active">Nilai Raport</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Form Filter Kelas & Mata Pelajaran</h5>
                        
                        <form action="{{ route('nilai.raport-input') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Tahun Ajaran --</option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ $selectedTa == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="semester_id" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester_id" id="semester_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem->id }}" {{ $selectedSem == $sem->id ? 'selected' : '' }}>
                                            {{ $sem->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mapels as $mp)
                                        <option value="{{ $mp->id }}" {{ $selectedMapel == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('nilai.raport-input') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm px-3" style="background-color: #0d6efd; border-color: #0d6efd;">
                                    <i class="bi bi-search"></i> Get Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary fw-bold p-0 mb-0">Form Input Nilai Raport</h5>
                            <button type="button" class="btn btn-info btn-sm text-white px-3" id="btn-auto-calc"><i class="bi bi-cpu"></i> Hitung Otomatis Semua</button>
                        </div>

                        @if(count($students) > 0)
                        <form action="{{ route('nilai.raport-input.save') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tahun_ajaran_id" value="{{ $selectedTa }}">
                            <input type="hidden" name="semester_id" value="{{ $selectedSem }}">
                            <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $selectedMapel }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-light fw-bold text-dark">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th style="width: 120px;">NISN</th>
                                            <th class="text-start">Nama Siswa</th>
                                            <th style="width: 150px;">Nilai Harian (Rata-rata LM)</th>
                                            <th style="width: 150px;">Nilai MID (UTS)</th>
                                            <th style="width: 150px;">Nilai PAS (UAS)</th>
                                            <th style="width: 180px;">Nilai Raport</th>
                                            <th style="width: 120px;">Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $index => $siswa)
                                            @php
                                                $rec = $siswa->nilai_record;
                                            @endphp
                                            <tr data-siswa-id="{{ $siswa->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td class="text-start fw-semibold">{{ $siswa->nama_siswa }}</td>
                                                <td class="harian-val">{{ $rec && $rec->nilai_harian !== null ? number_format($rec->nilai_harian, 1) : '.....' }}</td>
                                                <td class="mid-val">{{ $rec && $rec->nilai_mid !== null ? number_format($rec->nilai_mid, 1) : '.....' }}</td>
                                                <td class="pas-val">{{ $rec && $rec->nilai_pas !== null ? number_format($rec->nilai_pas, 1) : '.....' }}</td>
                                                <td>
                                                    <input type="number" step="1" min="0" max="100" 
                                                        name="nilai[{{ $siswa->id }}][nilai_raport]" 
                                                        class="form-control text-center score-input raport-input" 
                                                        value="{{ $rec && $rec->nilai_raport !== null ? intval($rec->nilai_raport) : '' }}">
                                                </td>
                                                <td class="predikat-cell fw-bold text-success">
                                                    {{ $rec && $rec->predikat ? $rec->predikat : '.....' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Nilai Raport</button>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data siswa ditemukan.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .score-input {
            width: 80px;
            height: 30px;
            padding: 2px;
            font-size: 0.85rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin: 0 auto;
            display: inline-block;
        }
        .score-input::-webkit-outer-spin-button,
        .score-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .score-input {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@push('script')
<script>
$(document).ready(function() {
    function getPredikat(score) {
        if (score >= 85) return 'A';
        if (score >= 75) return 'B';
        if (score >= 60) return 'C';
        return 'D';
    }

    // Auto-calculate on button click
    $('#btn-auto-calc').click(function() {
        $('tbody tr').each(function() {
            const harianText = $(this).find('.harian-val').text().trim();
            const midText = $(this).find('.mid-val').text().trim();
            const pasText = $(this).find('.pas-val').text().trim();

            if (harianText !== '.....' && midText !== '.....' && pasText !== '.....') {
                const harian = parseFloat(harianText);
                const mid = parseFloat(midText);
                const pas = parseFloat(pasText);

                // Formula: (2 * Harian + MID + PAS) / 4
                const raport = Math.round((2 * harian + mid + pas) / 4);
                $(this).find('.raport-input').val(raport);
                $(this).find('.predikat-cell').text(getPredikat(raport));
            }
        });
    });

    // Recalculate predikat on manual input change
    $('.raport-input').on('input', function() {
        const val = $(this).val();
        const predikatCell = $(this).closest('tr').find('.predikat-cell');
        
        if (val !== '' && !isNaN(val)) {
            predikatCell.text(getPredikat(parseFloat(val)));
        } else {
            predikatCell.text('.....');
        }
    });
});
</script>
@endpush
