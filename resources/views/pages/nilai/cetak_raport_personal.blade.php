@extends('layouts.dashboard.template')

@section('title', 'Cetak Raport')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Cetak Raport</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Cetak Raport</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold mb-3 p-0">Filter Cetak Raport</h5>
                        
                        <form action="{{ route('nilai.raport.personal') }}" method="GET" class="row g-3">
                            <div class="col-md-6">
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
                            
                            <div class="col-md-6">
                                <label for="semester_name" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester_name" id="semester_name" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Semester --</option>
                                    <option value="Semester 1 (Ganjil)" {{ $selectedSemName == 'Semester 1 (Ganjil)' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                                    <option value="Semester 2 (Genap)" {{ $selectedSemName == 'Semester 2 (Genap)' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                                <a href="{{ route('nilai.raport.personal') }}" class="btn btn-secondary text-white btn-sm px-3" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-dark btn-sm px-3" style="background-color: #212529; border-color: #212529;">
                                    <i class="bi bi-search"></i> Tampilkan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedTa && $selectedSem)
                <div class="card shadow-sm border-0">
                    <div class="card-body pt-4">
                        <h5 class="card-title text-primary fw-bold p-0 mb-4">Informasi Raport Siswa</h5>
                        
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 250px;" class="fw-semibold">Nama Siswa</td>
                                        <td style="width: 20px;">:</td>
                                        <td class="fw-bold text-dark">{{ $siswa->nama_siswa }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">NISN</td>
                                        <td>:</td>
                                        <td>{{ $siswa->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kelas</td>
                                        <td>:</td>
                                        <td>{{ $kelasModel->nama_kelas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Tahun Ajaran / Semester</td>
                                        <td>:</td>
                                        <td>{{ $tahunAjarans->firstWhere('id', $selectedTa)->nama_tahun_ajaran ?? '-' }} / {{ $selectedSemName }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4 text-md-end text-center pt-3 pt-md-0">
                                <a href="{{ route('nilai.cetak-raport.print', ['siswa_id' => $siswa->id, 'tahun_ajaran_id' => $selectedTa, 'semester_id' => $selectedSem]) }}" target="_blank" class="btn btn-dark btn-lg px-4" style="background-color: #212529; border-color: #212529; font-weight: bold; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.15);">
                                    <i class="bi bi-printer-fill me-2"></i> Cetak Raport
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
