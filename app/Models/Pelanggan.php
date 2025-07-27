<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function pemasangans()
    {
        return $this->hasMany(Pemasangan::class);
    }

    public function pemasangan()
    {
        return $this->hasOne(Pemasangan::class);
    }

    public function pemutusans()
    {
        return $this->hasMany(Pemutusan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
