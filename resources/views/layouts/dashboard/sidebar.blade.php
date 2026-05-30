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
      $isAkademik  = in_array($role, ['admin', 'kepala sekolah', 'guru', 'wali kelas']);
      $isPersonal  = in_array($role, ['siswa', 'orang tua']);
  @endphp

  <ul class="sidebar-nav" id="sidebar-nav">

    {{-- ═══════════════════════════════
         DASHBOARD (semua role)
    ═══════════════════════════════ --}}
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
         href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
      </a>
    </li>

    {{-- ═══════════════════════════════
         MANAJEMEN DATA
         Hanya: admin, kepala sekolah
    ═══════════════════════════════ --}}
    @if ($isManajemen)
      <li class="nav-heading">Manajemen Data</li>

      {{-- Manajemen User: hanya admin --}}
      @if ($isAdmin)
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('user.*') ? '' : 'collapsed' }}"
             href="{{ route('user.index') }}">
            <i class="bi bi-person-gear"></i>
            <span>Manajemen User</span>
          </a>
        </li>
      @endif

      {{-- Data Siswa --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('siswa.*') ? '' : 'collapsed' }}"
           href="{{ route('siswa.index') }}">
          <i class="bi bi-person-lines-fill"></i>
          <span>Data Siswa</span>
        </a>
      </li>

      {{-- Orang Tua --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('orang-tua.*') ? '' : 'collapsed' }}"
           href="{{ route('orang-tua.index') }}">
          <i class="bi bi-person-hearts"></i>
          <span>Orang Tua / Wali</span>
        </a>
      </li>

      {{-- Data Guru --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('guru.*') ? '' : 'collapsed' }}"
           href="{{ route('guru.index') }}">
          <i class="bi bi-person-badge"></i>
          <span>Data Guru</span>
        </a>
      </li>

      {{-- Data Kelas --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kelas.*') ? '' : 'collapsed' }}"
           data-bs-target="#kelas-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i>
          <span>Data Kelas</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kelas-nav"
            class="nav-content collapse {{ request()->routeIs('kelas.*', 'walikelas.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('kelas.index') }}" class="{{ request()->routeIs('kelas.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Daftar Kelas</span>
            </a>
          </li>
          @if ($isAdmin)
            <li>
              <a href="{{ route('walikelas.index') }}" class="{{ request()->routeIs('walikelas.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Penugasan Wali Kelas</span>
              </a>
            </li>
          @endif
        </ul>
      </li>

      {{-- Data Pegawai --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('pegawai.*') ? '' : 'collapsed' }}"
           href="{{ route('pegawai.index') }}">
          <i class="bi bi-people"></i>
          <span>Data Pegawai</span>
        </a>
      </li>

    @endif {{-- end isManajemen --}}


    {{-- ═══════════════════════════════
         AKADEMIK
         Hanya: admin, kepala sekolah, guru, wali kelas
    ═══════════════════════════════ --}}
    @if ($isAkademik)
      <li class="nav-heading">Akademik</li>

      {{-- Mata Pelajaran: admin & kepala sekolah (view) --}}
      @if ($isManajemen)
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('matapelajaran.*') ? '' : 'collapsed' }}"
             href="{{ route('matapelajaran.index') }}">
            <i class="bi bi-book"></i>
            <span>Mata Pelajaran</span>
          </a>
        </li>
      @endif

      {{-- Nilai --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai.*') ? '' : 'collapsed' }}"
           data-bs-target="#nilai-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-check"></i>
          <span>Nilai</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nilai-nav"
            class="nav-content collapse {{ request()->routeIs('nilai.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
          @if (in_array($role, ['admin', 'guru', 'wali kelas']))
            <li>
              <a href="{{ route('nilai.create') }}" class="{{ request()->routeIs('nilai.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Input Nilai</span>
              </a>
            </li>
          @endif
          <li>
            <a href="{{ route('nilai.index') }}" class="{{ request()->routeIs('nilai.index') && !request()->routeIs('nilai.create') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Rekap Nilai</span>
            </a>
          </li>
        </ul>
      </li>

      {{-- Kehadiran --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran.*', 'jeniskehadiran.*') ? '' : 'collapsed' }}"
           data-bs-target="#kehadiran-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i>
          <span>Kehadiran</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kehadiran-nav"
            class="nav-content collapse {{ request()->routeIs('kehadiran.*', 'jeniskehadiran.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
          @if (in_array($role, ['admin', 'guru', 'wali kelas']))
            <li>
              <a href="{{ route('kehadiran.create') }}" class="{{ request()->routeIs('kehadiran.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Input Kehadiran</span>
              </a>
            </li>
          @endif
          <li>
            <a href="{{ route('kehadiran.index') }}" class="{{ request()->routeIs('kehadiran.index') && !request()->routeIs('kehadiran.create') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Rekap Kehadiran</span>
            </a>
          </li>
          @if ($isManajemen)
            <li>
              <a href="{{ route('jeniskehadiran.index') }}" class="{{ request()->routeIs('jeniskehadiran.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Master Jenis Kehadiran</span>
              </a>
            </li>
          @endif
        </ul>
      </li>

      {{-- Catatan Siswa: guru & wali kelas --}}
      @if (in_array($role, ['admin', 'guru', 'wali kelas']))
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('catatansiswa.*') ? '' : 'collapsed' }}"
             data-bs-target="#catatan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-chat-square-text"></i>
            <span>Catatan Siswa</span>
            <i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="catatan-nav"
              class="nav-content collapse {{ request()->routeIs('catatansiswa.*') ? 'show' : '' }}"
              data-bs-parent="#sidebar-nav">
            <li>
              <a href="#" class="{{ request()->routeIs('catatansiswa.create') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Buat Catatan</span>
              </a>
            </li>
            <li>
              <a href="#" class="{{ request()->routeIs('catatansiswa.index') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>Daftar Catatan</span>
              </a>
            </li>
          </ul>
        </li>
      @endif

      {{-- Ekstrakurikuler --}}
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekstrakurikuler.*') ? '' : 'collapsed' }}"
           href="{{ route('ekstrakurikuler.index') }}">
          <i class="bi bi-trophy"></i>
          <span>Ekstrakurikuler</span>
        </a>
      </li>

    @endif {{-- end isAkademik --}}


    {{-- ═══════════════════════════════
         AKADEMIK SAYA
         Hanya: siswa, orang tua
    ═══════════════════════════════ --}}
    @if ($isPersonal)
      <li class="nav-heading">
        {{ $isSiswa ? 'Akademik Saya' : 'Akademik Anak' }}
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('nilai-saya.*') ? '' : 'collapsed' }}" href="#">
          <i class="bi bi-journal-check"></i>
          <span>{{ $isSiswa ? 'Nilai Saya' : 'Nilai Anak' }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kehadiran-saya.*') ? '' : 'collapsed' }}" href="#">
          <i class="bi bi-calendar-check"></i>
          <span>{{ $isSiswa ? 'Kehadiran Saya' : 'Kehadiran Anak' }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('catatan-saya.*') ? '' : 'collapsed' }}" href="#">
          <i class="bi bi-chat-square-text"></i>
          <span>{{ $isSiswa ? 'Catatan Saya' : 'Catatan Anak' }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('ekskul-saya.*') ? '' : 'collapsed' }}" href="#">
          <i class="bi bi-trophy"></i>
          <span>Ekstrakurikuler</span>
        </a>
      </li>

    @endif {{-- end isPersonal --}}


    {{-- ═══════════════════════════════
         INFORMASI (semua role)
    ═══════════════════════════════ --}}
    <li class="nav-heading">Informasi</li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('pengumuman.*') ? '' : 'collapsed' }}" href="#">
        <i class="bi bi-megaphone"></i>
        <span>Pengumuman</span>
      </a>
    </li>

    {{-- Tahun Ajaran & Semester: hanya admin & kepala sekolah --}}
    @if ($isManajemen)
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tahun-ajaran.*', 'semester.*') ? '' : 'collapsed' }}"
           data-bs-target="#tahun-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar3"></i>
          <span>Tahun Ajaran</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tahun-nav"
            class="nav-content collapse {{ request()->routeIs('tahun-ajaran.*', 'semester.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('tahun-ajaran.index') }}" class="{{ request()->routeIs('tahun-ajaran.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Tahun Ajaran</span>
            </a>
          </li>
          <li>
            <a href="{{ route('semester.index') }}" class="{{ request()->routeIs('semester.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Semester</span>
            </a>
          </li>
        </ul>
      </li>
    @endif


    {{-- ═══════════════════════════════
         AKUN (semua role)
    ═══════════════════════════════ --}}
    <li class="nav-heading">Akun</li>

    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}" id="sidebarLogout">
        @csrf
        <a class="nav-link collapsed" href="#"
           onclick="event.preventDefault(); document.getElementById('sidebarLogout').submit();">
          <i class="bi bi-box-arrow-right"></i>
          <span>Keluar</span>
        </a>
      </form>
    </li>

  </ul>

</aside>{{-- End Sidebar --}}
