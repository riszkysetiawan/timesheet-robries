<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;
    protected $table = 'company_profiles';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
