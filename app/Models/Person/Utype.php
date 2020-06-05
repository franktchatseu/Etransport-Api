<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Model;

class Utype extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'utypes';
}
