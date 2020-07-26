<?php

namespace App\Models\module3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class modele extends Model
{
    use SoftDeletes;

    protected $table = 'models';

}
