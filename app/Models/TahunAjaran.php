<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function isActive()
    {
        return $this->status;
    }

    public function kelasSiswas()
    {
        return $this->hasMany(KelasSiswa::class, 'tahun_ajaran_id');
    }

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'tahun_ajaran_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'tahun_ajaran_id');
    }

    public function perilaku()
    {
        return $this->hasMany(Perilaku::class, 'tahun_ajaran_id');
    }
}
