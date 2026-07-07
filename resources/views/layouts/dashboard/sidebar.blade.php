{{-- ======= Sidebar ======= --}}
<aside id="sidebar" class="sidebar">

  @php
      $role  = Auth::user()->roles ?? '';
      $name  = Auth::user()->name  ?? 'Pengguna';

      $isAdmin    = $role === 'admin';
      $isKepsek   = $role === 'kepala sekolah';
      $isGuru     = $role === 'guru';
      $isWali     = $role === 'wali kelas';
      $isSiswa    = $role === 'siswa';
      $isOrangTua = $role === 'orang tua';

      // Kelompok peran
      $isManajemen = in_array($role, ['admin', 'kepala sekolah']);
      $isGuruWali  = in_array($role, ['guru', 'wali kelas']);
      $isPersonal  = in_array($role, ['siswa', 'orang tua']);
  @endphp

  <ul class="sidebar-nav" id="sidebar-nav">

    {{-- DASHBOARD (semua role) --}}
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>
    </li>

    {{-- ==========================================
         A. MENU UNTUK ADMIN & KEPALA SEKOLAH
         ========================================== --}}
    @if ($isManajemen)

      {{-- 1. DATA MASTER --}}
      <li class="nav-heading">Data Master</li>
      
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('siswa.*') ? '' : 'collapsed' }}" href="{{ route('siswa.index') }}">
          <i class="bi bi-person-lines-fill"></i><span>Siswa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('guru.*') ? '' : 'collapsed' }}" href="{{ route('guru.index') }}">
          <i class="bi bi-person-badge"></i><span>Guru</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pegawai.*') ? '' : 'collapsed' }}" href="{{ route('pegawai.index') }}">
          <i class="bi bi-people"></i><span>Pegawai</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('jabatan.*') ? '' : 'collapsed' }}" href="{{ route('jabatan.index') }}">
          <i class="bi bi-briefcase"></i><span>Jabatan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('orang-tua.*') ? '' : 'collapsed' }}" href="{{ route('orang-tua.index') }}">
          <i class="bi bi-person-hearts"></i><span>Orang Tua / Wali</span>
        </a>
      </li>

      {{-- 2. DATA AKADEMIK --}}
      <li class="nav-heading">Data Akademik</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kelas.*', 'walikelas.*', 'pembagiankelas.*') ? '' : 'collapsed' }}"
           data-bs-target="#kelas-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i><span>Kelas & Penugasan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kelas-nav" class="nav-content collapse {{ request()->routeIs('kelas.*', 'walikelas.*', 'pembagiankelas.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Daftar Kelas</span></a></li>
          @if($isAdmin)
          <li><a href="{{ route('walikelas.index') }}" class="{{ request()->routeIs('walikelas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Wali Kelas</span></a></li>
          <li><a href="{{ route('pembagiankelas.index') }}" class="{{ request()->routeIs('pembagiankelas.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Pembagian Kelas</span></a></li>
          @endif
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('matapelajaran.*') ? '' : 'collapsed' }}" href="{{ route('matapelajaran.index') }}">
          <i class="bi bi-book"></i><span>Mata Pelajaran</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekstrakurikuler.*') ? '' : 'collapsed' }}" href="{{ route('ekstrakurikuler.index') }}">
          <i class="bi bi-trophy"></i><span>Ekstrakurikuler</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tahun-ajaran.*', 'semester.*') ? '' : 'collapsed' }}"
           data-bs-target="#tahun-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar3"></i><span>Tahun Ajaran & Smt</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tahun-nav" class="nav-content collapse {{ request()->routeIs('tahun-ajaran.*', 'semester.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('tahun-ajaran.index') }}" class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Tahun Ajaran</span></a></li>
          <li><a href="{{ route('semester.index') }}" class="{{ request()->routeIs('semester.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Semester</span></a></li>
        </ul>
      </li>

      {{-- 3. LAPORAN & TRANSAKSI --}}
      <li class="nav-heading">Laporan & Rekapitulasi</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.*') ? '' : 'collapsed' }}" href="{{ route('nilai.index') }}">
          <i class="bi bi-journal-check"></i><span>Rekap Nilai</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran.*', 'jeniskehadiran.*') ? '' : 'collapsed' }}"
           data-bs-target="#kehadiran-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i><span>Kehadiran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kehadiran-nav" class="nav-content collapse {{ request()->routeIs('kehadiran.*', 'jeniskehadiran.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('kehadiran.index') }}" class="{{ request()->routeIs('kehadiran.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Kehadiran</span></a></li>
          <li><a href="{{ route('jeniskehadiran.index') }}" class="{{ request()->routeIs('jeniskehadiran.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Jenis Kehadiran</span></a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('catatansiswa.*', 'jeniscatatan.*') ? '' : 'collapsed' }}"
           data-bs-target="#catatan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Catatan Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="catatan-nav" class="nav-content collapse {{ request()->routeIs('catatansiswa.*', 'jeniscatatan.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('catatansiswa.index') }}" class="{{ request()->routeIs('catatansiswa.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Catatan</span></a></li>
          <li><a href="{{ route('jeniscatatan.index') }}" class="{{ request()->routeIs('jeniscatatan.*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Jenis Catatan</span></a></li>
        </ul>
      </li>
    
    @endif


    {{-- ==========================================
         B. MENU UNTUK GURU & WALI KELAS
         ========================================== --}}
    @if ($isGuru)
      
      <li class="nav-heading">Akademik & Kelas</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.*') ? '' : 'collapsed' }}"
           data-bs-target="#nilai-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-check"></i><span>Nilai Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nilai-nav" class="nav-content collapse {{ request()->routeIs('nilai.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li class="px-3 py-1 text-secondary fw-semibold fs-7" style="font-size: 0.8rem; list-style-type: none;"><i class="bi bi-star me-1 text-warning"></i> Input Nilai</li>
          <li><a href="{{ route('nilai.harian') }}" class="{{ request()->routeIs('nilai.harian') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Nilai Harian</span></a></li>
          <li><a href="{{ route('nilai.mid') }}" class="{{ request()->routeIs('nilai.mid') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Nilai MID</span></a></li>
          <li><a href="{{ route('nilai.pas') }}" class="{{ request()->routeIs('nilai.pas') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Nilai PAS</span></a></li>
          <li><a href="{{ route('nilai.raport-input') }}" class="{{ request()->routeIs('nilai.raport-input') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Nilai Raport</span></a></li>
          
          <li class="px-3 py-1 mt-2 text-secondary fw-semibold fs-7" style="font-size: 0.8rem; list-style-type: none;"><i class="bi bi-star me-1 text-warning"></i> Rekap Nilai</li>
          <li><a href="{{ route('nilai.rekap-mapel') }}" class="{{ request()->routeIs('nilai.rekap-mapel') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Nilai Per Mapel</span></a></li>
          <li><a href="{{ route('nilai.rekap-raport') }}" class="{{ request()->routeIs('nilai.rekap-raport') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Nilai Raport</span></a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran.*') ? '' : 'collapsed' }}"
           data-bs-target="#kehadiran-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i><span>Kehadiran Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kehadiran-nav" class="nav-content collapse {{ request()->routeIs('kehadiran.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('kehadiran.create') }}" class="{{ request()->routeIs('kehadiran.create') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Kehadiran</span></a></li>
          <li><a href="{{ route('kehadiran.index') }}" class="{{ request()->routeIs('kehadiran.index') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Kehadiran</span></a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('catatansiswa.*') ? '' : 'collapsed' }}"
           data-bs-target="#catatan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Catatan Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="catatan-nav" class="nav-content collapse {{ request()->routeIs('catatansiswa.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li><a href="{{ route('catatansiswa.create') }}" class="{{ request()->routeIs('catatansiswa.create') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Input Catatan</span></a></li>
          <li><a href="{{ route('catatansiswa.index') }}" class="{{ request()->routeIs('catatansiswa.index') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Rekap Catatan</span></a></li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekstrakurikuler.*') ? '' : 'collapsed' }}" href="{{ route('ekstrakurikuler.index') }}">
          <i class="bi bi-trophy"></i><span>Ekstrakurikuler</span>
        </a>
      </li>

    @endif

    @if ($isWali)
      
      <li class="nav-heading">Nilai Siswa</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.rekap-raport') ? '' : 'collapsed' }}" href="{{ route('nilai.rekap-raport') }}">
          <i class="bi bi-star"></i><span>Rekap Nilai</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.cetak-raport') ? '' : 'collapsed' }}" href="{{ route('nilai.cetak-raport') }}">
          <i class="bi bi-star"></i><span>Cetak Raport</span>
        </a>
      </li>

      <li class="nav-heading">Kehadiran Siswa</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran.index') ? '' : 'collapsed' }}" href="{{ route('kehadiran.index') }}">
          <i class="bi bi-star"></i><span>Rekap Kehadiran</span>
        </a>
      </li>

      <li class="nav-heading">Ekstrakurikuler Siswa</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekstrakurikuler.index') ? '' : 'collapsed' }}" href="{{ route('ekstrakurikuler.index') }}">
          <i class="bi bi-star"></i><span>Input Ekstrakurikuler</span>
        </a>
      </li>

      <li class="nav-heading">Informasi & Pengaturan</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pengumuman.index') ? '' : 'collapsed' }}" href="{{ route('pengumuman.index') }}">
          <i class="bi bi-star"></i><span>Pengumuman</span>
        </a>
      </li>

    @endif


    {{-- ==========================================
         C. MENU UNTUK SISWA & ORANG TUA
         ========================================== --}}
    @if ($isPersonal)
      
      <li class="nav-heading">{{ $isSiswa ? 'Laporan Akademik Saya' : 'Laporan Akademik Anak' }}</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.*') ? '' : 'collapsed' }}" href="{{ route('nilai.index') }}">
          <i class="bi bi-journal-check"></i><span>Nilai</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran.*') ? '' : 'collapsed' }}" href="{{ route('kehadiran.index') }}">
          <i class="bi bi-calendar-check"></i><span>Kehadiran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('catatansiswa.*') ? '' : 'collapsed' }}" href="{{ route('catatansiswa.index') }}">
          <i class="bi bi-chat-square-text"></i><span>Catatan Perilaku</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekstrakurikuler.*') ? '' : 'collapsed' }}" href="{{ route('ekstrakurikuler.index') }}">
          <i class="bi bi-trophy"></i><span>Ekstrakurikuler</span>
        </a>
      </li>

    @endif


    {{-- ==========================================
         D. INFORMASI & PENGATURAN UMUM
         ========================================== --}}
    @if (!$isWali)
      <li class="nav-heading">Informasi & Pengaturan</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profil-sekolah.*') ? '' : 'collapsed' }}" href="{{ route('profil-sekolah.index') }}">
          <i class="bi bi-info-circle"></i><span>Profil Sekolah</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pengumuman.*') ? '' : 'collapsed' }}" href="{{ route('pengumuman.index') }}">
          <i class="bi bi-megaphone"></i><span>Pengumuman</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('materipembelajaran.*') ? '' : 'collapsed' }}" href="{{ route('materipembelajaran.index') }}">
          <i class="bi bi-book"></i><span>Materi Pembelajaran</span>
        </a>
      </li>
    @endif

    @if ($isAdmin)
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.*') ? '' : 'collapsed' }}" href="{{ route('user.index') }}">
          <i class="bi bi-person-gear"></i><span>Manajemen User / Pengguna</span>
        </a>
      </li>
    @endif

    {{-- Keluar --}}
    <li class="nav-heading">Akun</li>
    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}" id="sidebarLogout">
        @csrf
        <a class="nav-link collapsed" href="#" onclick="event.preventDefault(); document.getElementById('sidebarLogout').submit();">
          <i class="bi bi-box-arrow-right"></i><span>Keluar</span>
        </a>
      </form>
    </li>

  </ul>

</aside>{{-- End Sidebar --}}
