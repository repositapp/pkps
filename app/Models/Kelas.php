<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswas', 'kelas_id', 'siswa_id')
            ->withPivot('tahun_ajaran_id');
    }

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'kelas_id');
    }

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapels', 'kelas_id', 'guru_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'kelas_id');
    }

    public function perilaku()
    {
        return $this->hasMany(Perilaku::class, 'kelas_id');
    }
}
