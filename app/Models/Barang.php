<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    // Relasi ke wasteStocks
    public function wasteStocks()
    {
        return $this->hasMany(Waste::class, 'kode_barang', 'kode_barang');
    }

    // Relasi ke satuan (corrected to belongsTo)
    public function satuan()
    {
        return $this->belongsTo(SatuanBarang::class, 'id_satuan', 'id');
    }

    // Relasi ke stocks
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'kode_barang', 'kode_barang');
    }

    // Relasi ke detail outgoing
    public function detailoutgoing()
    {
        return $this->hasMany(DetailOutgoing::class, 'kode_barang', 'kode_barang');
    }

    // Mapping relasi lain jika diperlukan
    public function mapping()
    {
        return $this->hasMany(Kategori::class, 'kode_barang', 'kode_barang');
    }
}
