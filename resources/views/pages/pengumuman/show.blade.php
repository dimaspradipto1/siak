@extends('layouts.dashboard.template')

@section('title', 'Detail Pengumuman')

@section('content')
    <div class="pagetitle">
        <h1 class="text-primary fw-bold">Detail Pengumuman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2" style="border-bottom: 1px solid #f2f2f2;">
                            <h4 class="text-dark fw-bold mb-0">{{ $pengumuman->judul }}</h4>
                            <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 0.85rem; border-radius: 6px;">
                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($pengumuman->created_at)->locale('id')->translatedFormat('l, d F Y') }}
                            </span>
                        </div>

                        <div class="mb-4 text-dark" style="font-size: 1.05rem; line-height: 1.7; white-space: pre-line;">
                            {!! e($pengumuman->keterangan) !!}
                        </div>

                        <div class="card bg-light border-0 mb-4" style="border-radius: 8px;">
                            <div class="card-body py-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-secondary d-block">Dipublikasikan Oleh</small>
                                        <span class="fw-bold text-dark">{{ $pengumuman->user?->name ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-secondary d-block">Tahun Ajaran / Semester</small>
                                        <span class="fw-bold text-dark">
                                            {{ $pengumuman->tahunAjaran ? $pengumuman->tahunAjaran->tahun_mulai . '/' . $pengumuman->tahunAjaran->tahun_selesai : '-' }} 
                                            ({{ $pengumuman->semester?->nama_semester ?? '-' }})
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-secondary d-block">Kelas Sasaran</small>
                                        <span class="fw-bold text-dark">{{ $pengumuman->kelas?->nama_kelas ?? 'Semua Kelas' }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-secondary d-block">Mata Pelajaran</small>
                                        <span class="fw-bold text-dark">{{ $pengumuman->mataPelajaran?->nama_mata_pelajaran ?? 'Semua Mata Pelajaran' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start">
                            <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary px-4 py-2" style="border-radius: 8px; font-weight: bold;">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
