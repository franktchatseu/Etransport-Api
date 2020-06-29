<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\MakingAppointment;
use Faker\Generator as Faker;

$factory->define(MakingAppointment::class, function (Faker $faker) {
    return [
        //
        'hour' => $faker->time,
        'date'=> $faker->date,
        'comment'=> $faker->sentence,
        'status' => $faker->randomElement(['PENDING', 'APPROVED', 'REJECTED']),
    ];
});