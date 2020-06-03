<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Planification\TypePlaning;
use Faker\Generator as Faker;

$factory->define(TypePlaning::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(),
        'name' => $faker->sentence(),
    ];
});
