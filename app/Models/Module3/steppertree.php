<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class steppertree extends Model
{
    use SoftDeletes;
    protected $table = 'stepper_trees';
}
