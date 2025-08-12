<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perilaku Siswa - {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .header {
            margin-bottom: 15px;
            text-align: center;
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

        th {
            background-color: #f0f0f0;
        }

        td.nama {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Perilaku Siswa</h2>
        <h4>Kelas {{ $kelas->nama_kelas }}</h4>
        <p>Tahun Ajaran: {{ $tahunAjaran->tahun_ajaran }} ({{ ucfirst($tahunAjaran->semester) }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Taat</th>
                <th>Disiplin</th>
                <th>Melanggar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="nama">{{ $row['siswa']->nama_siswa }}</td>
                    <td>{{ $row['taat'] }}</td>
                    <td>{{ $row['disiplin'] }}</td>
                    <td>{{ $row['melanggar'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
