<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;
    protected $table = 'packing';
    protected $guarded = ['id'];

    public function detailPackings()
    {
        return $this->hasMany(DetailPacking::class, 'id_packing', 'id');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id');
    }
}
