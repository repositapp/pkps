<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'guru_id');
    }

    public function pelajarans()
    {
        return $this->belongsToMany(Pelajaran::class, 'guru_mapels', 'guru_id', 'pelajaran_id')
            ->withPivot('kelas_id', 'tahun_ajaran_id');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_mapels', 'guru_id', 'kelas_id');
    }
}
