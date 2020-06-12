<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Pattern;
use Faker\Generator as Faker;

$factory->define(Pattern::class, function (Faker $faker) {
    return [
        'reason' => $faker->sentence,
        'description' => $faker->sentence
    ];
});
