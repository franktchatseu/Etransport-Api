<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Cathechumene;
use Faker\Generator as Faker;

$factory->define(Cathechumene::class, function (Faker $faker) {
    return [
        'father_tel' => $faker->sentence,
        'godfather_tel' => $faker->sentence,
        'catechese_level' => $faker->randomDigit(1, 3),
        'catechese_place' => $faker->sentence,
        'birth_certificate' => $faker->imageUrl(),
        
    ];
});
