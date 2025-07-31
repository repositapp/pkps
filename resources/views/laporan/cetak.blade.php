<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judulLaporan }} - {{ $barber->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #555;
        }

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 2px 5px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        table.data th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table.data tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #777;
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $barber->nama }}</h1>
        <h2>{{ $judulLaporan }}</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($dariTanggal)->locale('id')->translatedFormat('d F Y') }}
            s/d {{ \Carbon\Carbon::parse($sampaiTanggal)->locale('id')->translatedFormat('d F Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Alamat:</strong></td>
                <td>{{ $barber->alamat }}</td>
                <td width="15%"></td>
                <td><strong>Telepon:</strong></td>
                <td>{{ $barber->telepon }}</td>
            </tr>
            <tr>
                <td><strong>Pemilik:</strong></td>
                <td>{{ $barber->nama_pemilik }}</td>
                <td></td>
                <td><strong>Email:</strong></td>
                <td>{{ $barber->email }}</td>
            </tr>
        </table>
    </div>

    @if ($jenisLaporan == 'pemesanan')
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">ID</th>
                    <th width="20%">Pelanggan</th>
                    <th width="20%">Layanan</th>
                    <th width="15%">Tanggal</th>
                    <th width="10%">Waktu</th>
                    <th width="20%" class="text-right">Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $pemesanan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $pemesanan->id }}</td>
                        <td>{{ $pemesanan->user->name ?? '-' }}</td>
                        <td>{{ $pemesanan->layanan->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->locale('id')->translatedFormat('d/m/Y') }}
                        </td>
                        <td>{{ $pemesanan->waktu_pemesanan }}</td>
                        <td class="text-right">{{ number_format($pemesanan->layanan->harga ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><strong>Total Pendapatan:</strong></td>
                    <td class="text-right">
                        <strong>
                            Rp
                            {{ number_format($data->sum(function ($item) {return $item->layanan->harga ?? 0;}),0,',','.') }}
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    @elseif($jenisLaporan == 'keuangan')
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">ID Transaksi</th>
                    <th width="10%">ID Pemesanan</th>
                    <th width="20%">Pelanggan</th>
                    <th width="20%">Layanan</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $transaksi)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $transaksi->id }}</td>
                        <td>{{ $transaksi->pemesanan->id ?? '-' }}</td>
                        <td>{{ $transaksi->user->name ?? '-' }}</td>
                        <td>{{ $transaksi->pemesanan->layanan->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('d/m/Y H:i') }}
                        </td>
                        <td class="text-right">{{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><strong>Total Pendapatan:</strong></td>
                    <td class="text-right">
                        <strong>Rp {{ number_format($data->sum('jumlah'), 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak pada {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y H:i:s') }}</p>
    </div>

    <script>
        // Script untuk otomatis membuka dialog print saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
