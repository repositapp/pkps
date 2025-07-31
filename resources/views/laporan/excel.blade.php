<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 16px; font-weight: bold;">
                {{ $judul }}
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">
                Periode: {{ \Carbon\Carbon::parse($dariTanggal)->locale('id')->translatedFormat('d F Y') }}
                s/d {{ \Carbon\Carbon::parse($sampaiTanggal)->locale('id')->translatedFormat('d F Y') }}
            </th>
        </tr>
        <tr>
            <th></th> <!-- Spacer untuk header merge -->
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @if ($jenisLaporan == 'pemesanan')
            <tr>
                <th>No.</th>
                <th>ID Pemesanan</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Harga (Rp)</th>
            </tr>
        @elseif($jenisLaporan == 'keuangan')
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>ID Pemesanan</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Tanggal</th>
                <th>Jumlah (Rp)</th>
            </tr>
        @endif
    </thead>
    <tbody>
        @forelse ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>

                @if ($jenisLaporan == 'pemesanan')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->layanan->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d/m/Y') }}</td>
                    <td>{{ $item->waktu_pemesanan }}</td>
                    <td>{{ number_format($item->layanan->harga ?? 0, 0, ',', '.') }}</td>
                @elseif($jenisLaporan == 'keuangan')
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->pemesanan->id ?? '-' }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->pemesanan->layanan->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($item->jumlah ?? 0, 0, ',', '.') }}</td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;">
                @if ($jenisLaporan == 'pemesanan')
                    Total Pendapatan:
                @elseif($jenisLaporan == 'keuangan')
                    Total Pendapatan:
                @endif
            </td>
            <td style="font-weight: bold;">
                @if ($jenisLaporan == 'pemesanan')
                    Rp
                    {{ number_format($data->sum(function ($item) {return $item->layanan->harga ?? 0;}),0,',','.') }}
                @elseif($jenisLaporan == 'keuangan')
                    Rp {{ number_format($data->sum('jumlah'), 0, ',', '.') }}
                @endif
            </td>
        </tr>
    </tfoot>
</table>
