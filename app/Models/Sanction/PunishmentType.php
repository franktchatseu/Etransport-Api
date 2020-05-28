<?php

namespace App\Models\Sanction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PunishmentType extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
