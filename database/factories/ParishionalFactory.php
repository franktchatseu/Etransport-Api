<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Parishional;
use Faker\Generator as Faker;

$factory->define(Parishional::class, function (Faker $faker) {
    return [
        'quarter' =>  $faker->sentence,
        'isBaptist' => $faker->boolean(),
    ];
});
