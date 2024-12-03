<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $table = 'waste';
    protected $guarded = ['id'];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    public function alasanWaste()
    {
        return $this->belongsTo(AlasanWaste::class, 'id_alasan', 'id');
    }
}
