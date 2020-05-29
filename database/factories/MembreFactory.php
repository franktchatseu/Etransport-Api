<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Membre;
use Faker\Generator as Faker;

$factory->define(Membre::class, function (Faker $faker) {
    return [
        'matricule' => $faker->unique()->sentence,
        'adhesion_date' => $faker->date,
        'is_finish' => $faker->boolean(),
        'file' => $faker->sentence,
        'status' => $faker->randomElement(['Rejected','Painding','Accepted']),
    ];
});
