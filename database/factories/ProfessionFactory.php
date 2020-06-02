<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Profession;
use Faker\Generator as Faker;

$factory->define(Profession::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
