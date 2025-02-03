<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBom extends Model
{
    use HasFactory;
    protected $table = 'detail_bom';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $guarded = [];
    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id', 'id_bom');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}
