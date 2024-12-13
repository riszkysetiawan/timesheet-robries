<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $table = 'timer';
    protected $guarded = ['id'];
    public function proses()
    {
        return $this->belongsTo(Proses::class, 'id_proses', 'id');
    }

    public function production()
    {
        return $this->belongsTo(Production::class, 'so_number', 'so_number');
    }

    public function detailProduction()
    {
        return $this->belongsTo(DetailProduction::class, 'barcode', 'barcode');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
