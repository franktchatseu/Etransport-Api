<?php

namespace App\Models\Module1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stepper_Main extends Model
{
    use SoftDeletes;
    protected $table = 'stepper_mains';

}
