<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    protected $table = 'proses';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'proses', 'id');
    }
    public function timer()
    {
        return $this->hasOne(Timer::class);
    }

    public function timers()
    {
        return $this->hasMany(Timer::class, 'id_proses', 'id');
    }
}
