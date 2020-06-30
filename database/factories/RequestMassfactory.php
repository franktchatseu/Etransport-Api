<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\RequestMass;
use Faker\Generator as Faker;

$factory->define(RequestMass::class, function (Faker $faker) {
    return [
        'hour' => $faker->time,
        'date'=> $faker->date,
        'place'=> $faker->streetName,
        'amount' => $faker->numberBetween(10, 100),
        'description'=> $faker->sentence,
        'status' => $faker->randomElement(['PENDING', 'APPROVED', 'REJECTED']),
    ];
});
