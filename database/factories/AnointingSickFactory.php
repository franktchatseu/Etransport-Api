<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\AnointingSick;
use Faker\Generator as Faker;

$factory->define(AnointingSick::class, function (Faker $faker) {
    return [
        'good_to_know' => $faker->text,
        'assisted_person' => $faker->name,
        'age' => $faker->numberBetween(0,120),
        'gender' => $faker->randomElement(['F', 'M']),
        'quater' => $faker->streetName(),
        'disease_nature' => $faker->sentence,
        'is_baptisted' => $faker->boolean(),
        'request_date' => $faker->date(),
        'comment' => $faker->text,
        'status' => $faker->randomElement(['REJECTED','PENDING','ACCEPTED']),


    ];
});
