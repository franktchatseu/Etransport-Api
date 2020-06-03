<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Evaluation;
use Faker\Generator as Faker;

$factory->define(Evaluation::class, function (Faker $faker) {
    return [
        'evaluation_type' => $faker->sentence,
        'note' => $faker->numberBetween(0,1000),
    ];
});
