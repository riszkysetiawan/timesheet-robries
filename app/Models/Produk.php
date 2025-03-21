<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'kode_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function dailyStockHistories()
    {
        return $this->hasMany(DailyStockHistory::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size', 'id');
    }
    public function warna()
    {
        return $this->belongsTo(Warna::class, 'id_warna', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'kode_produk', 'kode_produk');
    }

    public function mapping()
    {
        return $this->hasMany(Stock::class, 'kode_produk', 'kode_produk');
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

    public function production()
    {
        return $this->hasMany(Production::class, 'kode_produk');
    }
}
