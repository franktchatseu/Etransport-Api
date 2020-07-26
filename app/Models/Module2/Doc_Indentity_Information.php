<?php

namespace App\Models\Module2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc_Indentity_Information extends Model
{
    use SoftDeletes;

    protected $table = 'doc_indentity_informations';

}
