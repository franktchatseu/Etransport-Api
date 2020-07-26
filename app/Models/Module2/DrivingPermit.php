<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrivingPermit extends Model
{
    use SoftDeletes;

    protected $table = 'driving_permits';

}
