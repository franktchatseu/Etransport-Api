<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place\Place;
use Faker\Generator as Faker;

$factory->define(Place::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'description' => $faker->sentence,

    ];
});
