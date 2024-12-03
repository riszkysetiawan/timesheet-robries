<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlasanWaste extends Model
{
    protected $table = 'alasan_waste';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function wastes()
    {
        return $this->hasMany(Waste::class, 'id_alasan');
    }
}
