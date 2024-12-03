<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInbond extends Model
{
    use HasFactory;
    protected $table = 'detail_inbound';
    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = true;
    protected $guarded = [];
}
