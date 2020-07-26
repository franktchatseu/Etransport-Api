<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class General_Info extends Model
{
    use SoftDeletes;

    protected $table = 'general_infos';

}
