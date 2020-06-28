<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnointingSick extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
}
