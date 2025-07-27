<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('status', 1)->orderBy('order');
    }

    public function target()
    {
        return match ($this->type) {
            'halaman' => $this->belongsTo(Halaman::class, 'target_id'),
            'pengumuman' => $this->belongsTo(Pengumuman::class, 'target_id'),
            default => null,
        };
    }
}
