<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailProduction extends Model
{
    protected $table = 'detail_production';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $guarded = [];

    public function production()
    {
        return $this->belongsTo(Production::class, 'so_number', 'so_number');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}
