<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'packing';
    protected $guarded = ['id'];
    public function packing()
    {
        return $this->hasMany(Packing::class, 'id_penjualan', 'id');
    }
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id');
    }
}
