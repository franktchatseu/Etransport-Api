<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sanction\Sanction;
use Faker\Generator as Faker;

$factory->define(Sanction::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
    ];
});
