<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gearpicture extends Model
{
    use SoftDeletes;

    protected $table = 'gear_pictures';

}
