@extends('layouts.dashboard.template')

@section('title', 'Edit Data Mata Pelajaran')

@section('content')
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark fs-4">Form Edit Mata Pelajaran</h1>
    </div>

    @php
        // Helper: pastikan nilai TP selalu berupa array (support data lama berupa string biasa)
        function tpItems($value): array {
            if (is_array($value)) return array_values(array_filter($value));
            if (is_string($value) && $value !== '') {
                // Coba decode JSON dulu
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return array_values(array_filter($decoded));
                }
                // Fallback: anggap sebagai 1 item
                return [$value];
            }
            return [];
        }
        $tpOptimalItems     = tpItems($matapelajaran->tp_optimal);
        $tpPeningkatanItems = tpItems($matapelajaran->tp_peningkatan);
        if (empty($tpOptimalItems))     $tpOptimalItems     = [''];
        if (empty($tpPeningkatanItems)) $tpPeningkatanItems = [''];
    @endphp

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <form action="{{ route('matapelajaran.update', $matapelajaran->id) }}" method="POST" id="formEditMapel">
                            @csrf
                            @method('PUT')

                            {{-- Kode Mata Pelajaran --}}
                            <div class="mb-3">
                                <label for="kode_mapel" class="form-label fw-medium text-secondary">Kode Mata Pelajaran</label>
                                <input type="text" id="kode_mapel" name="kode_mapel" 
                                    class="form-control rounded-3 @error('kode_mapel') is-invalid @enderror" 
                                    value="{{ old('kode_mapel', $matapelajaran->kode_mapel) }}" placeholder="Masukkan Kode Mata Pelajaran">
                                @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Nama Mata Pelajaran --}}
                            <div class="mb-3">
                                <label for="nama_mata_pelajaran" class="form-label fw-medium text-secondary">Nama Mata Pelajaran</label>
                                <input type="text" id="nama_mata_pelajaran" name="nama_mata_pelajaran" 
                                    class="form-control rounded-3 @error('nama_mata_pelajaran') is-invalid @enderror" 
                                    value="{{ old('nama_mata_pelajaran', $matapelajaran->nama_mata_pelajaran) }}" required placeholder="Masukkan Nama Mata Pelajaran">
                                @error('nama_mata_pelajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- KKM --}}
                            <div class="mb-3">
                                <label for="kkm" class="form-label fw-medium text-secondary">KKM</label>
                                <input type="number" id="kkm" name="kkm" 
                                    class="form-control rounded-3 @error('kkm') is-invalid @enderror" 
                                    value="{{ old('kkm', $matapelajaran->kkm) }}" placeholder="Masukkan KKM">
                                @error('kkm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- TP yang Diukur & Tercapai Optimal --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary">
                                    TP yang Diukur &amp; Tercapai Optimal
                                    <span class="badge bg-primary ms-1" style="font-size:0.7rem;">Bisa lebih dari 1</span>
                                </label>
                                @error('tp_optimal')
                                    <div class="text-danger small mb-1">{{ $message }}</div>
                                @enderror
                                <div id="tp-optimal-list" class="d-flex flex-column gap-2 mb-2">
                                    @foreach($tpOptimalItems as $i => $item)
                                    <div class="input-group tp-optimal-item">
                                        <span class="input-group-text bg-primary text-white border-0" style="width:32px;">{{ $i + 1 }}</span>
                                        <input type="text" name="tp_optimal[]"
                                            class="form-control rounded-end-3"
                                            value="{{ old('tp_optimal.' . $i, $item) }}"
                                            placeholder="Masukkan Tujuan Pembelajaran ke-{{ $i + 1 }}">
                                        <button type="button" class="btn btn-outline-danger btn-sm ms-1 rounded-3 remove-tp" title="Hapus"
                                            style="{{ count($tpOptimalItems) === 1 ? 'display:none;' : '' }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-tp-optimal" class="btn btn-sm btn-outline-primary rounded-3">
                                    <i class="bi bi-plus-circle"></i> Tambah TP Optimal
                                </button>
                            </div>

                            {{-- TP yang Diukur & Perlu Peningkatan --}}
                            <div class="mb-4">
                                <label class="form-label fw-medium text-secondary">
                                    TP yang Diukur &amp; Perlu Peningkatan
                                    <span class="badge bg-warning text-dark ms-1" style="font-size:0.7rem;">Bisa lebih dari 1</span>
                                </label>
                                @error('tp_peningkatan')
                                    <div class="text-danger small mb-1">{{ $message }}</div>
                                @enderror
                                <div id="tp-peningkatan-list" class="d-flex flex-column gap-2 mb-2">
                                    @foreach($tpPeningkatanItems as $i => $item)
                                    <div class="input-group tp-peningkatan-item">
                                        <span class="input-group-text bg-warning text-dark border-0" style="width:32px;">{{ $i + 1 }}</span>
                                        <input type="text" name="tp_peningkatan[]"
                                            class="form-control rounded-end-3"
                                            value="{{ old('tp_peningkatan.' . $i, $item) }}"
                                            placeholder="Masukkan Tujuan Pembelajaran ke-{{ $i + 1 }}">
                                        <button type="button" class="btn btn-outline-danger btn-sm ms-1 rounded-3 remove-tp" title="Hapus"
                                            style="{{ count($tpPeningkatanItems) === 1 ? 'display:none;' : '' }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-tp-peningkatan" class="btn btn-sm btn-outline-warning rounded-3">
                                    <i class="bi bi-plus-circle"></i> Tambah TP Peningkatan
                                </button>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top">
                                <a href="{{ route('matapelajaran.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-dark px-4 py-2 rounded-3">
                                    Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: `<ul class="text-start ps-3 mb-0">{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
                confirmButtonColor: '#d33',
            });
        @endif

        // =============================================
        // Dynamic TP List (Tambah / Hapus baris TP)
        // =============================================
        function setupTpList(listId, addBtnId, itemClass, nameAttr, badgeBg, badgeText) {
            function renumber() {
                const items = $('#' + listId + ' .' + itemClass);
                items.each(function(i) {
                    $(this).find('span.input-group-text').text(i + 1);
                    $(this).find('input').attr('placeholder', 'Masukkan Tujuan Pembelajaran ke-' + (i + 1));
                });
                items.find('.remove-tp').show();
                if (items.length === 1) {
                    items.first().find('.remove-tp').hide();
                }
            }

            $('#' + addBtnId).click(function() {
                const count = $('#' + listId + ' .' + itemClass).length + 1;
                const html = `
                    <div class="input-group ${itemClass}">
                        <span class="input-group-text ${badgeBg} ${badgeText} border-0" style="width:32px;">${count}</span>
                        <input type="text" name="${nameAttr}[]"
                            class="form-control rounded-end-3"
                            placeholder="Masukkan Tujuan Pembelajaran ke-${count}">
                        <button type="button" class="btn btn-outline-danger btn-sm ms-1 rounded-3 remove-tp" title="Hapus">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>`;
                $('#' + listId).append(html);
                renumber();
                $('#' + listId + ' .' + itemClass + ':last input').focus();
            });

            $(document).on('click', '#' + listId + ' .remove-tp', function() {
                $(this).closest('.' + itemClass).remove();
                renumber();
            });
        }

        setupTpList('tp-optimal-list',     'add-tp-optimal',     'tp-optimal-item',     'tp_optimal',     'bg-primary',  'text-white');
        setupTpList('tp-peningkatan-list',  'add-tp-peningkatan', 'tp-peningkatan-item', 'tp_peningkatan', 'bg-warning',  'text-dark');
    </script>
@endpush

