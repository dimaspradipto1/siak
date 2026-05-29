@extends('layouts.dashboard.template')

@section('title', 'Dashboard')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Selamat Datang -->
                    <div class="col-12 mb-3">
                        <div class="card border-0"
                            style="background: linear-gradient(135deg, #0d2a6e, #1a4fad); color: #fff; border-radius: 16px;">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-white"
                                        style="width:56px;height:56px;font-size:24px;font-weight:700;color:#1a4fad;flex-shrink:0;">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-white">
                                            Selamat Datang, {{ $user->name ?? 'Pengguna' }}!
                                        </h5>
                                        <p class="mb-0" style="opacity:.8;font-size:13px;">
                                            <i class="bi bi-shield-check me-1"></i>
                                            Role: <strong class="text-capitalize">{{ $user->roles ?? '-' }}</strong>
                                            &nbsp;·&nbsp; SIAK SD Negeri 007 Sekupang
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Cards -->
                    @if (in_array($user->roles ?? '', ['admin', 'kepala sekolah']))
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #4154f1;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Siswa</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e8eafd;">
                                            <i class="bi bi-person-lines-fill" style="color:#4154f1;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Data dari database</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Siswa Card -->

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #2eca6a;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Guru</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e0f8ec;">
                                            <i class="bi bi-person-badge" style="color:#2eca6a;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Data dari database</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Guru Card -->

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #ff771d;">
                                <div class="card-body">
                                    <h5 class="card-title">Total Kelas</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#fff0e6;">
                                            <i class="bi bi-building" style="color:#ff771d;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Data dari database</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Kelas Card -->
                    @endif

                    @if (in_array($user->roles ?? '', ['guru', 'wali kelas']))
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #4154f1;">
                                <div class="card-body">
                                    <h5 class="card-title">Kelas Saya</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e8eafd;">
                                            <i class="bi bi-building" style="color:#4154f1;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Kelas yang diampu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #2eca6a;">
                                <div class="card-body">
                                    <h5 class="card-title">Mata Pelajaran</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e0f8ec;">
                                            <i class="bi bi-book" style="color:#2eca6a;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Mapel yang diajarkan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (in_array($user->roles ?? '', ['siswa', 'orang tua']))
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #4154f1;">
                                <div class="card-body">
                                    <h5 class="card-title">Rata-rata Nilai</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e8eafd;">
                                            <i class="bi bi-journal-check" style="color:#4154f1;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Semester ini</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #2eca6a;">
                                <div class="card-body">
                                    <h5 class="card-title">Kehadiran</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#e0f8ec;">
                                            <i class="bi bi-calendar-check" style="color:#2eca6a;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Bulan ini</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card" style="border-left: 4px solid #ff771d;">
                                <div class="card-body">
                                    <h5 class="card-title">Ekskul Diikuti</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                            style="background:#fff0e6;">
                                            <i class="bi bi-trophy" style="color:#ff771d;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>—</h6>
                                            <span class="text-muted small">Kegiatan aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pengumuman Terbaru -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pengumuman Terbaru</h5>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-megaphone" style="font-size:40px;opacity:.3;"></i>
                                    <p class="mt-2 mb-0">Belum ada pengumuman saat ini.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Pengumuman -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Info Pengguna -->
                <div class="card">
                    <div class="card-body pt-4">
                        <h5 class="card-title">Informasi Akun</h5>
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                                style="width:72px;height:72px;font-size:28px;font-weight:700;">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                            <h6 class="mt-2 mb-1">{{ $user->name ?? '-' }}</h6>
                            <p class="text-muted small mb-0">{{ $user->email ?? '-' }}</p>
                            <span class="badge bg-primary mt-1 text-capitalize">{{ $user->roles ?? '-' }}</span>
                        </div>
                        <hr>
                        <ul class="list-unstyled small">
                            <li class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted"><i class="bi bi-person me-2"></i>Nama</span>
                                <strong>{{ $user->name ?? '-' }}</strong>
                            </li>
                            <li class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted"><i class="bi bi-envelope me-2"></i>Email</span>
                                <strong>{{ $user->email ?? '-' }}</strong>
                            </li>
                            <li class="d-flex justify-content-between py-1">
                                <span class="text-muted"><i class="bi bi-shield-check me-2"></i>Role</span>
                                <strong class="text-capitalize">{{ $user->roles ?? '-' }}</strong>
                            </li>
                        </ul>
                    </div>
                </div><!-- End Info Pengguna -->

                <!-- Info Sekolah -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Info Sekolah</h5>
                        <ul class="list-unstyled small">
                            <li class="d-flex align-items-start gap-2 py-2 border-bottom">
                                <i class="bi bi-building text-primary mt-1"></i>
                                <div>
                                    <strong>SD Negeri 007 Sekupang</strong><br>
                                    <span class="text-muted">Kota Batam, Kepulauan Riau</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2 py-2 border-bottom">
                                <i class="bi bi-calendar3 text-primary mt-1"></i>
                                <div>
                                    <strong>Tahun Ajaran</strong><br>
                                    <span class="text-muted">{{ date('Y') }}/{{ date('Y') + 1 }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2 py-2">
                                <i class="bi bi-clock text-primary mt-1"></i>
                                <div>
                                    <strong>Waktu Login</strong><br>
                                    <span
                                        class="text-muted">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- End Info Sekolah -->

            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
