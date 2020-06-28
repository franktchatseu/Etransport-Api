<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\RequestMass;
use Faker\Generator as Faker;

$factory->define(RequestMass::class, function (Faker $faker) {
    return [
        'request_hour' => $faker->time,
        'request_date'=> $faker->date,
        'place'=> $faker->sentence,
        'state' => 'PENDING',
    ];
});
