<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $guarded = ['id'];
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'id_supplier');
    }

    public function inbounds()
    {
        return $this->hasMany(Inbound::class, 'id_supplier');
    }
}
