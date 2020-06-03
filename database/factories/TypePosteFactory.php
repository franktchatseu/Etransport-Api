<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place\TypePoste;
use Faker\Generator as Faker;

$factory->define(TypePoste::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
        'name' => $faker->sentence,
    ];
});
