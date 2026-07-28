@extends('layouts.dashboard.template')

@section('title', 'Rekap Kehadiran Siswa')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Rekap Kehadiran Siswa</h1>
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
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Form Rekap Kehadiran</h5>

                        <form action="{{ route('kehadiran.rekap') }}" method="GET" class="row g-4">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_id" class="form-label fw-semibold text-dark">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" {{ $selectedTa == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->nama_tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="semester_name" class="form-label fw-semibold text-dark">Semester</label>
                                <select name="semester_name" id="semester_name" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kelas_id" class="form-label fw-semibold text-dark">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="mata_pelajaran_id" class="form-label fw-semibold text-dark">Mata Pelajaran</label>
                                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    @foreach($mapels as $mp)
                                        <option value="{{ $mp->id }}" {{ (string) $selectedMapel === (string) $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama_mata_pelajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="bulan" class="form-label fw-semibold text-dark">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected>-- Pilih Bulan --</option>
                                    @foreach($bulanOptions as $opt)
                                        <option value="{{ $opt['value'] }}" {{ (string) $selectedBulan === (string) $opt['value'] ? 'selected' : '' }}>
                                            {{ $opt['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end align-items-center gap-4 pt-2">
                                <a href="{{ route('kehadiran.rekap') }}" class="text-dark fw-bold text-decoration-none small" style="font-size: 0.95rem;">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Tampilkan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas && $selectedMapel && $selectedBulan)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        @if(count($students) > 0 && count($tanggalList) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle text-center table-borderless table-striped">
                                <thead style="border-bottom: 2px solid #dee2e6;">
                                    <tr class="text-dark fw-bold" style="font-size: 1rem;">
                                        <th style="padding: 12px 16px; width: 60px;">No</th>
                                        <th style="padding: 12px 16px; width: 140px;">NISN</th>
                                        <th class="text-start" style="padding: 12px 16px;">Nama Siswa</th>
                                        @foreach($tanggalList as $tgl)
                                            <th style="padding: 12px 8px;" title="{{ \Carbon\Carbon::parse($tgl)->locale('id')->isoFormat('D MMMM Y') }}">
                                                {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $siswa)
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td style="padding: 14px 16px;">{{ $index + 1 }}</td>
                                            <td class="text-dark fw-semibold" style="padding: 14px 16px;">{{ $siswa->nisn }}</td>
                                            <td class="text-start fw-bold text-dark" style="padding: 14px 16px;">{{ $siswa->nama_siswa }}</td>
                                            @foreach($tanggalList as $tgl)
                                                @php
                                                    $rec = $siswa->kehadiran_by_date->get($tgl);
                                                    $kode = $rec?->jenisKehadiran?->kode_kehadiran;
                                                @endphp
                                                <td style="padding: 14px 8px;">
                                                    @if($kode)
                                                        <span class="fw-bold {{ $kode === 'H' ? 'text-success' : ($kode === 'A' ? 'text-danger' : 'text-warning') }}">{{ $kode }}</span>
                                                    @else
                                                        <span class="text-muted">.</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('kehadiran.rekap.print', request()->all()) }}" target="_blank" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold;">
                                <i class="bi bi-printer-fill me-1"></i> Cetak
                            </a>
                        </div>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada data kehadiran pada bulan yang dipilih.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
$(document).ready(function() {
    const currMapelId = "{{ $selectedMapel }}";

    function loadMapel() {
        const taId = $('#tahun_ajaran_id').val();
        const semName = $('#semester_name').val();
        const kelasId = $('#kelas_id').val();

        const mapelSelect = $('#mata_pelajaran_id');
        mapelSelect.empty().append('<option value="" disabled selected>-- Pilih Mata Pelajaran --</option>');

        if (!taId || !semName || !kelasId) {
            return;
        }

        $.ajax({
            url: "{{ route('kehadiran.rekap.get-mapel') }}",
            type: "GET",
            data: { tahun_ajaran_id: taId, semester_name: semName, kelas_id: kelasId },
            success: function(response) {
                response.mapels.forEach(function(m) {
                    const selected = currMapelId == m.id ? 'selected' : '';
                    mapelSelect.append(`<option value="${m.id}" ${selected}>${m.nama_mata_pelajaran}</option>`);
                });
            }
        });
    }

    $('#tahun_ajaran_id, #semester_name, #kelas_id').on('change', loadMapel);

    // Muat ulang Mata Pelajaran saat halaman dibuka dengan filter yang sudah terisi
    if ($('#tahun_ajaran_id').val() && $('#semester_name').val() && $('#kelas_id').val()) {
        loadMapel();
    }
});
</script>
@endpush
