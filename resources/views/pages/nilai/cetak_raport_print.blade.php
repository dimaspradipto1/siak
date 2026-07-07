<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor_{{ str_replace(' ', '_', $siswa->nama_siswa) }}_{{ $semester->nama_semester }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 40px;
            font-size: 14px;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            padding: 4px;
            vertical-align: top;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.main-table th, table.main-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }

        table.main-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .fw-bold {
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            font-size: 15px;
            margin-top: 20px;
            margin-bottom: 8px;
        }

        .signature-container {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .signature-table td {
            border: none;
            padding: 10px;
            text-align: center;
            vertical-align: top;
            width: 33%;
        }

        .print-btn-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .btn-print {
            background-color: #198754;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }

        .btn-print:hover {
            background-color: #157347;
        }

        @media print {
            .print-btn-container {
                display: none;
            }
            body {
                padding: 20px;
            }
            @page {
                size: A4;
                margin: 2cm;
            }
        }
    </style>
</head>
<body>

    <div class="print-btn-container">
        <button class="btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Rapor</button>
    </div>

    <div class="title">LAPORAN HASIL BELAJAR (RAPOR)</div>

    <table class="header-table">
        <tr>
            <td style="width: 15%;">Nama Sekolah</td>
            <td style="width: 2%;">:</td>
            <td style="width: 43%;" class="fw-bold">{{ $school->nama_sekolah ?? 'SD Negeri 007 Sekupang' }}</td>
            <td style="width: 15%;">Kelas</td>
            <td style="width: 2%;">:</td>
            <td style="width: 23%;">{{ $kelasModel->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $school->alamat_sekolah ?? 'Sekupang, Kota Batam' }}</td>
            <td>Semester</td>
            <td>:</td>
            <td>{{ $semester->nama_semester ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>:</td>
            <td class="fw-bold">{{ $siswa->nama_siswa }}</td>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td>{{ $tahunAjaran->nama_tahun_ajaran ?? '-' }}</td>
        </tr>
        <tr>
            <td>NISN / NIS</td>
            <td>:</td>
            <td>{{ $siswa->nisn }} / {{ $siswa->user->username ?? '-' }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="section-title">A. Nilai Akademik</div>
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Mata Pelajaran</th>
                <th style="width: 10%;">KKM</th>
                <th style="width: 10%;">Nilai</th>
                <th style="width: 10%;">Predikat</th>
                <th style="width: 40%;">Capaian Kompetensi / Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classMapels as $index => $mp)
                @php
                    $rec = $grades[$mp->id] ?? null;
                    $nilai = $rec && $rec->nilai_raport !== null ? intval($rec->nilai_raport) : null;
                    $predikat = $rec && $rec->predikat ? $rec->predikat : null;
                    
                    // Generate smart description
                    $desc = '-';
                    if ($nilai !== null) {
                        if ($nilai >= 85) {
                            $desc = $mp->tp_optimal 
                                ? 'Menunjukkan penguasaan yang sangat baik dalam ' . lcfirst($mp->tp_optimal)
                                : 'Menunjukkan penguasaan kompetensi mata pelajaran dengan sangat baik.';
                        } elseif ($nilai >= 75) {
                            $desc = $mp->tp_optimal 
                                ? 'Menunjukkan penguasaan yang baik dalam ' . lcfirst($mp->tp_optimal)
                                : 'Menunjukkan penguasaan kompetensi mata pelajaran dengan baik.';
                        } else {
                            $desc = $mp->tp_peningkatan 
                                ? 'Perlu bimbingan dan peningkatan dalam ' . lcfirst($mp->tp_peningkatan)
                                : 'Perlu bimbingan lebih lanjut untuk meningkatkan kompetensi mata pelajaran.';
                        }
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-start">{{ $mp->nama_mata_pelajaran }}</td>
                    <td class="text-center">{{ $mp->kkm ?? 70 }}</td>
                    <td class="text-center fw-bold">{{ $nilai !== null ? $nilai : '-' }}</td>
                    <td class="text-center fw-bold">{{ $predikat !== null ? $predikat : '-' }}</td>
                    <td class="text-start" style="font-size: 13px;">{{ $desc }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">B. Kegiatan Ekstrakurikuler</div>
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Kegiatan Ekstrakurikuler</th>
                <th style="width: 60%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($ekskuls) && count($ekskuls) > 0)
                @foreach($ekskuls as $index => $ekskul)
                    @if($ekskul)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-start">{{ $ekskul->nama_ekskul }}</td>
                            <td class="text-start">Aktif mengikuti kegiatan {{ strtolower($ekskul->nama_ekskul) }} dengan kriteria Sangat Baik.</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-start">-</td>
                    <td class="text-start">-</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="display: flex; gap: 20px; justify-content: space-between; page-break-inside: avoid;">
        <div style="flex: 1;">
            <div class="section-title">C. Ketidakhadiran</div>
            <table class="main-table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 50%;" class="text-start">Sakit</td>
                        <td style="width: 50%;" class="text-center fw-bold">{{ $attendance['Sakit'] }} hari</td>
                    </tr>
                    <tr>
                        <td class="text-start">Izin</td>
                        <td class="text-center fw-bold">{{ $attendance['Izin'] }} hari</td>
                    </tr>
                    <tr>
                        <td class="text-start">Tanpa Keterangan</td>
                        <td class="text-center fw-bold">{{ $attendance['Alpa'] }} hari</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="flex: 1;">
            <div class="section-title">D. Catatan Wali Kelas</div>
            <div style="border: 1px solid #000; padding: 15px; min-height: 80px; font-size: 13px; font-style: italic;">
                {{ $catatan->isi_catatan ?? 'Siswa menunjukkan sikap belajar yang positif. Terus pertahankan dan tingkatkan motivasi belajarmu di semester berikutnya.' }}
            </div>
        </div>
    </div>

    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui<br>
                    Orang Tua/Wali Siswa,<br><br><br><br>
                    <strong><u>{{ $ortuNama }}</u></strong>
                </td>
                <td>
                    <br>
                    Mengetahui,<br>
                    Kepala Sekolah<br><br><br>
                    <strong><u>{{ $kepsekNama }}</u></strong><br>
                    NIP. {{ $kepsekNip }}
                </td>
                <td>
                    Batam, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                    Wali Kelas,<br><br><br><br>
                    <strong><u>{{ $waliKelas->guru?->pegawai?->nama_pegawai ?? '..........................................' }}</u></strong><br>
                    NIP. {{ $waliKelas->guru?->pegawai?->nip ?? '..........................................' }}
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
