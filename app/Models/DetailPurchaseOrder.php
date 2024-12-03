<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPurchaseOrder extends Model
{
    protected $table = 'detail_purchase_order';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $guarded = [];
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'kode_po', 'kode_po');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}
