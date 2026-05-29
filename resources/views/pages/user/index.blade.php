@extends('layouts.dashboard.template')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="pagetitle">
        <h1>Manajemen Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3 pt-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>Daftar Pengguna
                    </h5>
                    <a href="{{ route('user.create') }}"
                        class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Pengguna
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-hover align-middle" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $i => $user)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                                                style="width:36px;height:36px;font-size:14px;background:linear-gradient(135deg,#1a4fad,#0d9fd8);flex-shrink:0;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin'          => 'danger',
                                                'kepala sekolah' => 'dark',
                                                'guru'           => 'primary',
                                                'wali kelas'     => 'info',
                                                'siswa'          => 'success',
                                                'orang tua'      => 'warning',
                                            ];
                                            $color = $roleColors[$user->roles] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }} text-capitalize">
                                            {{ $user->roles }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->is_active)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        {{-- Hapus via SweetAlert --}}
                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-hapus"
                                            data-id="{{ $user->id }}"
                                            data-nama="{{ $user->name }}"
                                            data-action="{{ route('user.destroy', $user->id) }}"
                                            title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                        {{-- Form DELETE tersembunyi --}}
                                        <form id="form-hapus-{{ $user->id }}"
                                            action="{{ route('user.destroy', $user->id) }}"
                                            method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        // Inisialisasi DataTables
        $(document).ready(function () {
            $('#userTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json',
                },
                columnDefs: [
                    { orderable: false, targets: [0, 5] }
                ],
                pageLength: 10,
            });
        });

        // SweetAlert Konfirmasi Hapus
        document.querySelectorAll('.btn-hapus').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id    = this.dataset.id;
                const nama  = this.dataset.nama;

                Swal.fire({
                    title: 'Hapus Pengguna?',
                    html: `Anda yakin ingin menghapus pengguna:<br><strong class="text-danger">${nama}</strong>?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash-fill"></i> Ya, Hapus!',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true,
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading(),
                        });
                        document.getElementById('form-hapus-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush