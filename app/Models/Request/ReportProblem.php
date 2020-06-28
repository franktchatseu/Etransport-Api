<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportProblem extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
