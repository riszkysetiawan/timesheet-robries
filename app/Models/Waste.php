<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $table = 'waste';
    protected $guarded = ['id'];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    public function alasanWaste()
    {
        return $this->belongsTo(AlasanWaste::class, 'id_alasan', 'id');
    }
}
