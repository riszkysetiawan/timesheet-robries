<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    protected $table = 'inbound';
    protected $primaryKey = 'kode_po';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    // Relasi dengan Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    // Relasi dengan DetailInbound (perbaiki nama kelas)
    public function detailInbounds()
    {
        return $this->hasMany(DetailInbond::class, 'kode_po', 'kode_po');
    }
}
