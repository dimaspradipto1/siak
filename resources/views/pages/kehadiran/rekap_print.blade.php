<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap_Kehadiran_{{ $kelasModel->nama_kelas ?? 'Kelas' }}_{{ str_replace(' ', '_', $selectedSemName) }}</title>
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
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            font-style: italic;
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
            width: 50%;
        }

        .print-btn-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .btn-print {
            background-color: #212529;
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
            background-color: #000;
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

    @php
    if (!function_exists('abbreviateMapel')) {
        function abbreviateMapel($name) {
            $map = [
                'Pendidikan Agama Islam' => 'PAI',
                'Pendidikan Agama Islam dan Budi Pekerti' => 'PAI',
                'Pendidikan Pancasila dan Kewarganegaraan' => 'PKN',
                'Pendidikan Pancasila' => 'PKN',
                'Bahasa Indonesia' => 'B.INDO',
                'Matematika' => 'MTK',
                'Ilmu Pengetahuan Alam dan Sosial' => 'IPAS',
                'Ilmu Pengetahuan Alam' => 'IPA',
                'Ilmu Pengetahuan Sosial' => 'IPS',
                'Seni Budaya dan Prakarya' => 'SBDP',
                'Seni Budaya dan Musik' => 'SBDM',
                'Seni Rupa' => 'Seni Rupa',
                'Bahasa Inggris' => 'B.ING',
                'Pendidikan Jasmani, Olahraga, dan Kesehatan' => 'PJOK',
            ];
            return $map[$name] ?? $name;
        }
    }
    @endphp

    <div class="print-btn-container">
        <button class="btn-print" onclick="window.print()">Cetak Rekap</button>
    </div>

    <div class="title">REKAPITULASI KEHADIRAN SISWA</div>
    <div class="subtitle">Kategori Kehadiran: {{ $jenisModel->nama_kehadiran ?? '-' }}</div>

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
            <td>{{ $selectedSemName ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td class="fw-bold">{{ $tahunAjaran->nama_tahun_ajaran ?? '-' }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">NISN</th>
                <th class="text-start">Nama Siswa</th>
                @foreach($classMapels as $mp)
                    <th>{{ abbreviateMapel($mp->nama_mata_pelajaran) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $siswa)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $siswa->nisn }}</td>
                    <td class="text-start fw-semibold">{{ $siswa->nama_siswa }}</td>
                    @foreach($classMapels as $mp)
                        <td class="text-center">
                            {{ $siswa->attendance_counts[$mp->id] ?? 0 }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Sekolah<br><br><br><br>
                    <strong><u>{{ $school->nama_kepala_sekolah ?? '..........................................' }}</u></strong><br>
                    NIP. {{ $school->nip_kepala_sekolah ?? '..........................................' }}
                </td>
                <td>
                    Batam, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                    Wali Kelas,<br><br><br><br>
                    <strong><u>{{ $waliKelas->guru->pegawai->nama_pegawai ?? '..........................................' }}</u></strong><br>
                    NIP. {{ $waliKelas->guru->pegawai->nip ?? '..........................................' }}
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
