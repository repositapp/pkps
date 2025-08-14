<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasSiswaImport implements ToModel, WithHeadingRow
{
    public $successCountSiswa = 0;
    public $skippedCountSiswa = 0;
    public $successCountKelas = 0;
    public $skippedCountKelas = 0;

    public function model(array $row)
    {
        $siswa = Siswa::where('nisn', $row['nisn'])->first();
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        if (!$siswa) {
            $this->skippedCountSiswa++;
            return null;
        }

        if (!$kelas) {
            $this->skippedCountKelas++;
            return null;
        }

        KelasSiswa::create([
            'siswa_id'       => $siswa->id,
            'kelas_id'      => $kelas->id,
            'tahun_ajaran_id'     => $tahunAjaran->id,
        ]);

        $this->successCountSiswa++;
        $this->successCountKelas++;
    }
}
