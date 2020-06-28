<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\MakingAppointment;
use Faker\Generator as Faker;

$factory->define(MakingAppointment::class, function (Faker $faker) {
    return [
        //
        'request_hour' => $faker->time,
        'request_date'=> $faker->date,
        'request_comment'=> $faker->sentence,
        'state' => 'PENDING',
    ];
});