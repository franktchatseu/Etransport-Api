<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\RequestForMass;
use Faker\Generator as Faker;

$factory->define(RequestForMass::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
