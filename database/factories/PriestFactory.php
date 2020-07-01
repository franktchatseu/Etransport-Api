<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Priest;
use Faker\Generator as Faker;

$factory->define(Priest::class, function (Faker $faker) {
    return [
        'ordination_place' => $faker->sentence,
        'ordination_godfather' => $faker->sentence,
        'career' => $faker->sentence,
        'description' => $faker->sentence,
        'function' => $faker->name,
        'ordination_date' => $faker->date,
    ];
});


