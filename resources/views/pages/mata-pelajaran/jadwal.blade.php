@extends('layouts.dashboard.template')

@section('title', 'Jadwal Mata Pelajaran')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Jadwal Mata Pelajaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Mata Pelajaran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-dark fw-bold mb-4 p-0">Daftar Jadwal Mata Pelajaran</h5>
                        
                        <form action="{{ route('matapelajaran.jadwal') }}" method="GET" class="row g-4">
                            <div class="col-md-4">
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
                            
                            <div class="col-md-4">
                                <label for="semester_name" class="form-label fw-semibold text-dark">Semester</label>
                                <select name="semester_name" id="semester_name" class="form-select py-2" style="border-radius: 8px;" required>
                                    <option value="" disabled selected></option>
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-md-4">
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

                            <div class="col-12 d-flex justify-content-end align-items-center gap-4 pt-2">
                                <a href="{{ route('matapelajaran.jadwal') }}" class="text-dark fw-bold text-decoration-none small" style="font-size: 0.95rem;">
                                    Reset
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2" style="background-color: #212529; border-color: #212529; border-radius: 8px; font-weight: bold; font-size: 0.95rem;">
                                    Tampilkan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem && $selectedKelas)
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        @if(count($matapelajaran) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle text-center table-borderless table-striped">
                                <thead style="border-bottom: 2px solid #dee2e6;">
                                    <tr class="text-dark fw-bold" style="font-size: 1rem;">
                                        <th style="padding: 12px 16px; width: 60px;">No</th>
                                        <th style="padding: 12px 16px;">Hari Pelajaran</th>
                                        <th style="padding: 12px 16px;">Jam Pelajaran</th>
                                        <th style="padding: 12px 16px;" class="text-start">Nama Mapel</th>
                                        <th style="padding: 12px 16px;">Semester</th>
                                        <th style="padding: 12px 16px;">Kelas</th>
                                        <th style="padding: 12px 16px;" class="text-start">Guru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($matapelajaran as $index => $mp)
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td style="padding: 14px 16px;">{{ $index + 1 }}</td>
                                            <td class="text-dark fw-bold" style="padding: 14px 16px;">{{ $mp->hari_mengajar }}</td>
                                            <td class="text-dark fw-semibold" style="padding: 14px 16px;">{{ $mp->jam_mengajar }}</td>
                                            <td class="text-start fw-bold text-primary" style="padding: 14px 16px;">{{ $mp->nama_mata_pelajaran }}</td>
                                            <td style="padding: 14px 16px;">{{ $mp->semester?->nama_semester }}</td>
                                            <td style="padding: 14px 16px;">{{ $mp->kelas?->nama_kelas }}</td>
                                            <td class="text-start text-dark fw-semibold" style="padding: 14px 16px;">
                                                {{ $mp->guru?->pegawai?->nama ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning text-center my-3"><i class="bi bi-exclamation-triangle-fill"></i> Tidak ada jadwal mata pelajaran untuk filter yang dipilih.</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
