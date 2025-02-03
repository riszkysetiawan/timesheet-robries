<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oven extends Model
{
    use HasFactory;
    protected $table = 'oven';
    protected $guarded = ['id'];
    // Dalam model Oven
    public function timers()
    {
        return $this->hasMany(Timer::class, 'id_oven');
    }
}
