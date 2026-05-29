  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        <i class="bi bi-mortarboard-fill" style="font-size:24px; color:#4154f1; margin-right:8px;"></i>
        <span class="d-none d-lg-block fw-bold">SIAK</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="GET" action="#">
        <input type="text" name="query" placeholder="Cari..." title="Masukkan kata kunci">
        <button type="submit" title="Cari"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon -->

        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">0</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Tidak ada notifikasi baru
            </li>
          </ul>
        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                  style="width:36px;height:36px;font-size:16px;font-weight:600;">
              {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </span>
            <span class="d-none d-md-block dropdown-toggle ps-2">
              {{ Auth::user()->name ?? 'Pengguna' }}
            </span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name ?? 'Pengguna' }}</h6>
              <span class="text-capitalize">{{ Auth::user()->roles ?? '-' }}</span>
            </li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>Profil Saya</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Akun</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <a class="dropdown-item d-flex align-items-center" href="#"
                   onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Keluar</span>
                </a>
              </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->