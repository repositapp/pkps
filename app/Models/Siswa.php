<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ortu()
    {
        return $this->hasOne(Ortu::class, 'siswa_id');
    }

    public function kelasSiswas()
    {
        return $this->hasMany(KelasSiswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswas', 'siswa_id', 'kelas_id')
            ->withPivot('tahun_ajaran_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'siswa_id');
    }

    public function perilakus()
    {
        return $this->hasMany(Perilaku::class, 'siswa_id');
    }
}
