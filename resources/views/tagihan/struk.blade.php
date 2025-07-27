<!DOCTYPE html>
<html>

<head>
    <title>Struk Tagihan PDAM</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 300px;
            /* Lebar struk */
            margin: 0 auto;
            border: 1px solid #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .info-pelanggan,
        .info-tagihan,
        .info-pembayaran {
            margin-bottom: 10px;
        }

        .info-pelanggan table,
        .info-tagihan table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-pelanggan td,
        .info-tagihan td {
            padding: 2px 0;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .border-top {
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>{{ $aplikasi->nama_lembaga }}</h2>
            <p>{{ $aplikasi->alamat }}</p>
            <p>Telp: {{ $aplikasi->telepon }} | Fax: {{ $aplikasi->fax }} | Email: {{ $aplikasi->email }}</p>
        </div>

        <div class="info-pelanggan">
            <table>
                <tr>
                    <td>ID Pelanggan</td>
                    <td class="right">{{ $tagihan->pelanggan->nomor_sambungan ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td class="right">{{ $tagihan->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td class="right">{{ Str::limit($tagihan->pelanggan->alamat, 20) }}</td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td class="right">{{ \Carbon\Carbon::parse($tagihan->periode)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Cetak</td>
                    <td class="right">{{ now()->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <div class="info-tagihan">
            <table>
                <tr>
                    <td>Meter Awal</td>
                    <td class="right">{{ number_format($tagihan->meter_awal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Meter Akhir</td>
                    <td class="right">{{ number_format($tagihan->meter_akhir, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Volume (m³)</td>
                    <td class="right">{{ number_format($tagihan->volume_air, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Administrasi</td>
                    <td class="right">Rp {{ number_format($tagihan->biaya_administrasi, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Air</td>
                    <td class="right">Rp {{ number_format($tagihan->biaya_air, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="info-pembayaran border-top">
            <table>
                <tr>
                    <td class="bold">Total Tagihan</td>
                    <td class="right bold">Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td class="right">
                        @if ($tagihan->status_pembayaran)
                            <span>Lunas</span>
                        @else
                            <span>Belum Lunas</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda</p>
            <p>Struk ini adalah bukti pembayaran yang sah</p>
        </div>
    </div>
</body>

</html>
