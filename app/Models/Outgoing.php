<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    use HasFactory;
    protected $table = 'outgoing';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function detailproductions()
    {
        return $this->hasMany(DetailOutgoing::class, 'id_outgoing', 'id');
    }
}
