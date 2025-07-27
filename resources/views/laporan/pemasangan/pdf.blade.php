<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemasangan Air Baru</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
        }

        .sub-title {
            font-size: 12px;
            margin-top: -5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            white-space: normal;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>KABUPATEN BUTON</h2>
        <h3>PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA TAKAWA</h3>
        <h3>LAPORAN PEMASANGAN</h3>
        <h5>BULAN {{ $bulan ? date('F Y', strtotime($tahun . '-' . $bulan . '-01')) : 'SEMUA PERIODE' }}</h5>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No.</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Deskripsi</th>
                <th>Tgl. Permohonan</th>
                <th>Status</th>
                <th>SPK Tgl</th>
                <th>SPK No</th>
                <th>BA Tgl</th>
                <th>BA No</th>
                <th>Merek Meteran</th>
                <th>Kedudukan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasangans as $index => $pemasangan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pemasangan->pelanggan->nama_pelanggan }}</td>
                    <td>{{ $pemasangan->pelanggan->alamat }}</td>
                    <td>{{ $pemasangan->pelanggan->nomor_telepon }}</td>
                    <td>{{ Str::limit($pemasangan->deskripsi, 40) }}</td>
                    <td>{{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d/m/Y') }}</td>
                    <td>
                        @switch($pemasangan->status)
                            @case('pending')
                                Pending
                            @break

                            @case('proses')
                                Proses
                            @break

                            @case('disetujui')
                                Disetujui
                            @break

                            @case('ditolak')
                                Ditolak
                            @break
                        @endswitch
                    </td>
                    <td>
                        {{ $pemasangan->spk_tanggal ? \Carbon\Carbon::parse($pemasangan->spk_tanggal)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $pemasangan->spk_nomor ?? '-' }}</td>
                    <td>
                        {{ $pemasangan->ba_tanggal ? \Carbon\Carbon::parse($pemasangan->ba_tanggal)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $pemasangan->ba_nomor ?? '-' }}</td>
                    <td>{{ $pemasangan->merek_meteran ?? '-' }}</td>
                    <td>{{ $pemasangan->kedudukan ? 'Perubahan' : 'Baru' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dibuat oleh:</p>
        <p><strong>[Nama Petugas]</strong></p>
        <p><em>[Jabatan]</em></p>
        <p>______________________</p>
    </div>
</body>

</html>
