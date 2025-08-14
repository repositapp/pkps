<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruMapelImport implements ToModel, WithHeadingRow
{
    public $successCountGuru = 0;
    public $skippedCountGuru = 0;
    public $successCountMapel = 0;
    public $skippedCountMapel = 0;
    public $successCountKelas = 0;
    public $skippedCountKelas = 0;

    public function model(array $row)
    {
        $guru = Guru::where('nip', $row['nip'])->first();
        $mapel = Pelajaran::where('nama_mapel', $row['nama_mapel'])->first();
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        if (!$guru) {
            $this->skippedCountGuru++;
            return null;
        }

        if (!$mapel) {
            $this->skippedCountMapel++;
            return null;
        }

        if (!$kelas) {
            $this->skippedCountKelas++;
            return null;
        }

        GuruMapel::create([
            'guru_id'       => $guru->id,
            'pelajaran_id'      => $mapel->id,
            'kelas_id'      => $kelas->id,
            'tahun_ajaran_id'     => $tahunAjaran->id,
            'hari'     => $row['hari'],
            'mulai' => $row['mulai'],
            'selesai'         => $row['selesai'],
        ]);

        $this->successCountGuru++;
        $this->successCountMapel++;
        $this->successCountKelas++;
    }
}
