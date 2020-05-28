<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Catechist;
use Faker\Generator as Faker;

$factory->define(Catechist::class, function (Faker $faker) {
    return [
        'catechist_date' => $faker->date,
        'catechist_place' => $faker->sentence,
    ];
});
