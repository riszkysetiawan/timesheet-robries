<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'kode_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function warna()
    {
        return $this->belongsTo(Warna::class, 'id_warna');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'kode_produk', 'kode_produk');
    }

    public function waste()
    {
        return $this->hasMany(Waste::class, 'kode_produk', 'kode_produk');
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class, 'detail_purchase_order', 'kode_produk', 'kode_po');
    }

    public function inboundDetails()
    {
        return $this->hasMany(DetailInbond::class, 'kode_produk');
    }

    public function productionDetails()
    {
        return $this->hasMany(DetailProduction::class, 'kode_produk');
    }
}
