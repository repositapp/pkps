<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'pelajaran_id');
    }

    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapels', 'pelajaran_id', 'guru_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'pelajaran_id');
    }

    public function perilaku()
    {
        return $this->hasMany(Perilaku::class, 'pelajaran_id');
    }
}
