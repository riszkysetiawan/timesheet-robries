<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    // protected $primaryKey = 'kode_po';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['tgl_buat'];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
    public function details()
    {
        return $this->hasMany(DetailPurchaseOrder::class, 'kode_po', 'kode_po');
    }

    public function detailPurchaseOrders()
    {
        return $this->hasMany(DetailPurchaseOrder::class, 'kode_po', 'kode_po');
    }

    public function inbounds()
    {
        return $this->hasMany(Inbound::class, 'kode_po', 'kode_po');
    }
}
