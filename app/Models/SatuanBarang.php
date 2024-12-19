<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBarang extends Model
{
    use HasFactory;
    protected $table = 'satuan_barang';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_satuan', 'id');
    }
}
