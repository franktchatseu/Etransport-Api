<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Liturgical\LiturgicalType;
use Faker\Generator as Faker;

$factory->define(LiturgicalType::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->randomElement(['CHANTS','PRIERES','HOMELIE','SAINT DU JOUR','LECTURE DU JOUR']),
        'description' => $faker->sentence
    ];
});
