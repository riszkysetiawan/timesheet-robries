<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaMapping extends Model
{
    use HasFactory;
    protected $table = 'area_mapping';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function mapping()
    {
        return $this->hasMany(Kategori::class, 'id_area', 'id');
    }
}
