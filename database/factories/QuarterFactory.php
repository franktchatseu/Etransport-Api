<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Quarter;
use Faker\Generator as Faker;

$factory->define(Quarter::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,
        'debut_date' => $faker->date,
        'end_date' => $faker->date
    ];
});
