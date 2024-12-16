<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPacking extends Model
{
    use HasFactory;
    protected $table = 'detail_packing';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $guarded = [];
    public function packing()
    {
        return $this->belongsTo(Packing::class, 'id_packing', 'id');
    }
}
