<?php

namespace App\Imports;

use App\Models\Siswa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Siswa([
            'nama_lengkap'   => $row['nama_lengkap'],
            'nisn'           => $row['nisn'],
            'tempat_lahir'   => $row['tempat_lahir'],
            'tanggal_lahir'  => Carbon::parse($row['tanggal_lahir']),
            'jenis_kelamin'  => $row['jenis_kelamin'],
            'agama'          => $row['agama'],
            'alamat'         => $row['alamat'],
            'asal_sekolah'   => $row['asal_sekolah'] ?? null,
            'tahun_lulus'    => $row['tahun_lulus'] ?? null,
            'nama_ayah'      => $row['nama_ayah'] ?? null,
            'nama_ibu'       => $row['nama_ibu'] ?? null,
            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
            'pekerjaan_ibu'  => $row['pekerjaan_ibu'] ?? null,
        ]);
    }
}
