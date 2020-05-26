<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Professions;
use Faker\Generator as Faker;

$factory->define(Professions::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
