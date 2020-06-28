<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MakingAppointment extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
}
