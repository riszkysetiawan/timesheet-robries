<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;
    protected $table = 'bom';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function detailBoms()
    {
        return $this->hasMany(Kategori::class, 'id_bom', 'id');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}
