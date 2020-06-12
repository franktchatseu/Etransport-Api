<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Trimestre;
use Faker\Generator as Faker;

$factory->define(Trimestre::class, function (Faker $faker) {
    return [
        'begin_date' => $faker->date,
        'end_date' => $faker->date,
        'number' => $faker->numberBetween(1,10),
    ];
});
