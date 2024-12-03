<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'production';
    protected $primaryKey = 'so_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public function detailProductions()
    {
        return $this->hasMany(DetailProduction::class, 'so_number', 'so_number');
    }

    public function timers()
    {
        return $this->hasMany(Timer::class, 'so_number', 'so_number');
    }
}
