<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'size';
    protected $guarded = ['id'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_size', 'id');
    }
    public function productions()
    {
        return $this->hasMany(Production::class, 'id_size', 'id');
    }
}
