<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place\TypePlace;
use Faker\Generator as Faker;

$factory->define(TypePlace::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'description' => $faker->sentence,
    ];
});
