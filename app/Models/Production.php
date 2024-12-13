<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'production';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function detailProductions()
    {
        return $this->hasMany(DetailProduction::class, 'so_number', 'so_number');
    }
    public function warna()
    {
        return $this->belongsTo(Warna::class, 'id_color', 'id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size', 'id');
    }

    public function proses()
    {
        return $this->hasMany(Proses::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    public function timers()
    {
        return $this->hasMany(Timer::class, 'id_production'); // Make sure this matches your foreign key
    }
}
