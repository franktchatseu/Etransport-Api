<?php

namespace App\Models\ModuleParc;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionOrder extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mission_orders';

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
    protected $fillable = ['car_id', 'driver_id', 'conveyor_id', 'number', 'file_number', 'subject', 'date_departure', 'return_date', 'departure_time', 'return_time', 'duration', 'start_index', 'return_index', 'actual_course', 'theorical_course', 'departure_city', 'fuel', 'factory_return'];

    
}
