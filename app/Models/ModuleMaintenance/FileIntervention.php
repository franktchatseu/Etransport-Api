<?php

namespace App\Models\ModuleMaintenance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileIntervention extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'file_interventions';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['car_id', 'card_number', 'status', 'receipt', 'index', 'degree_urgency', 'type_intervention', 'date_application', 'service_date', 'observation', 'initiated_by', 'commencement_date', 'termination_date', 'starting_time', 'end_time', 'allocated_real_time', 'down_time'];

    
}
