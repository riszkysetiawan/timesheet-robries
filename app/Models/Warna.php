<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    protected $table = 'warna';
    protected $guarded = ['id'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_warna', 'id');
    }
    public function productions()
    {
        return $this->hasMany(Production::class, 'id_color', 'id');
    }
    public function waste()
    {
        return $this->hasMany(Waste::class, 'id_warna', 'id');
    }
}
