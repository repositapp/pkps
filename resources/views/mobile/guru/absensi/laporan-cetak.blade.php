<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi - {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .header {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Absensi</h2>
        <h4>Kelas {{ $kelas->nama_kelas }} - {{ $tahunAjaran->tahun_ajaran }} ({{ ucfirst($tahunAjaran->semester) }})
        </h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="text-align: left;">{{ $row['siswa']->nama_lengkap }}</td>
                    <td>{{ $row['hadir'] }}</td>
                    <td>{{ $row['izin'] }}</td>
                    <td>{{ $row['sakit'] }}</td>
                    <td>{{ $row['alpa'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
