<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\Statut;
use Faker\Generator as Faker;

$factory->define(Statut::class, function (Faker $faker) {
    return [
        'name_post' => $faker->sentence,
        'role_post' => $faker->sentence
    ];
});
