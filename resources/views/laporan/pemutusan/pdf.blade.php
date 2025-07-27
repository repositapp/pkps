<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemutusan Air</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>KABUPATEN BUTON</h2>
        <h3>PERUSAHAAN UMUM DAERAH AIR MINUM TIRTA TAKAWA</h3>
        <h3>LAPORAN PEMUTUSAN</h3>
        <h4>BULAN {{ $bulan ? date('F Y', strtotime($tahun . '-' . $bulan . '-01')) : 'SEMUA PERIODE' }}</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pelanggan</th>
                <th>No. Sambungan</th>
                <th>Deskripsi</th>
                <th>Jumlah Tunggakan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemutusans as $index => $pemutusan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pemutusan->pelanggan->nama_pelanggan }}</td>
                    <td>{{ $pemutusan->pelanggan->nomor_sambungan ?? '-' }}</td>
                    <td>{{ $pemutusan->deskripsi }}</td>
                    <td>Rp {{ number_format($pemutusan->jumlah_tunggakan, 2, ',', '.') }}</td>
                    <td>
                        @if ($pemutusan->status == 'pending')
                            Pending
                        @elseif($pemutusan->status == 'proses')
                            Proses
                        @elseif($pemutusan->status == 'disetujui')
                            Disetujui
                        @elseif($pemutusan->status == 'ditolak')
                            Ditolak
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dibuat oleh:</p>
        <p>[Nama Petugas]</p>
        <p>[Jabatan]</p>
        <p>[Tanda Tangan]</p>
    </div>
</body>

</html>
