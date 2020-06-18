<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place\Poste;
use Faker\Generator as Faker;

$factory->define(Poste::class, function (Faker $faker) {
    return [
        'place' => $faker->sentence,
        'name' => $faker->sentence,
    ];
});
