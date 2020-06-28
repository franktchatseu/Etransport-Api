<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntentionMass extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
}
