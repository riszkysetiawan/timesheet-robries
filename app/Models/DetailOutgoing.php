<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOutgoing extends Model
{
    use HasFactory;
    protected $table = 'detail_outgoing';
    public $incrementing = false;
    protected $primaryKey = null;

    public function detailproductions()
    {
        return $this->belongsTo(Outgoing::class, 'id', 'id_outgoing');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}
