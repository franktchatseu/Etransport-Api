<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stepper_Driver extends Model
{
    use SoftDeletes;
    protected $table = 'stepper_drivers';
}
