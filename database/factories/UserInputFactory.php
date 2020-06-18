<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\UserInput;
use Faker\Generator as Faker;

$factory->define(UserInput::class, function (Faker $faker) {
    return [
        'amount' => $faker->sentence,
        'date' => $faker->date,
        'city' => $faker->sentence,
        'country' => $faker->sentence,
        'pseudo' => $faker->sentence,
        'provenance' => $faker->sentence
    ];
});
