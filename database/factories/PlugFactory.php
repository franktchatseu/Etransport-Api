<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Plug;
use Faker\Generator as Faker;

$factory->define(Plug::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'date' => $faker->date
    ];
});
