  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      {{-- Hanya tampil untuk Admin & Kepala Sekolah --}}
      @if(in_array(Auth::user()->roles ?? '', ['admin', 'kepala sekolah']))
      <li class="nav-heading">Manajemen Data</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#siswa-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>Data Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="siswa-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Siswa</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Tambah Siswa</span></a>
          </li>
        </ul>
      </li><!-- End Siswa Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#guru-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-badge"></i><span>Data Guru</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="guru-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Guru</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Tambah Guru</span></a>
          </li>
        </ul>
      </li><!-- End Guru Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#kelas-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i><span>Data Kelas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="kelas-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Kelas</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Wali Kelas</span></a>
          </li>
        </ul>
      </li><!-- End Kelas Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pegawai-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Data Pegawai</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pegawai-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Pegawai</span></a>
          </li>
        </ul>
      </li><!-- End Pegawai Nav -->
      @endif

      {{-- Akademik: Admin, Guru, Wali Kelas --}}
      @if(in_array(Auth::user()->roles ?? '', ['admin', 'guru', 'wali kelas', 'kepala sekolah']))
      <li class="nav-heading">Akademik</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#nilai-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-check"></i><span>Nilai</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nilai-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Input Nilai</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Rekap Nilai</span></a>
          </li>
        </ul>
      </li><!-- End Nilai Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#absensi-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i><span>Kehadiran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="absensi-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Input Kehadiran</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Rekap Kehadiran</span></a>
          </li>
        </ul>
      </li><!-- End Kehadiran Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#mapel-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-book"></i><span>Mata Pelajaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="mapel-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Mapel</span></a>
          </li>
        </ul>
      </li><!-- End Mata Pelajaran Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#ekskul-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-trophy"></i><span>Ekstrakurikuler</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="ekskul-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Daftar Ekskul</span></a>
          </li>
        </ul>
      </li><!-- End Ekskul Nav -->
      @endif

      {{-- Siswa & Orang Tua --}}
      @if(in_array(Auth::user()->roles ?? '', ['siswa', 'orang tua']))
      <li class="nav-heading">Akademik Saya</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-journal-check"></i>
          <span>Nilai Saya</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-calendar-check"></i>
          <span>Kehadiran Saya</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-trophy"></i>
          <span>Ekstrakurikuler</span>
        </a>
      </li>
      @endif

      <!-- Pengumuman - semua role -->
      <li class="nav-heading">Informasi</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-megaphone"></i>
          <span>Pengumuman</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tahun-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar3"></i><span>Tahun Ajaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tahun-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Semester</span></a>
          </li>
          <li>
            <a href="#"><i class="bi bi-circle"></i><span>Tahun Ajaran</span></a>
          </li>
        </ul>
      </li>

      <!-- Keluar -->
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

  </aside><!-- End Sidebar -->
