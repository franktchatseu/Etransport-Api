<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parishional extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
}
