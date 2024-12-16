<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori_barang';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id');
    }
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id');
    }
}
