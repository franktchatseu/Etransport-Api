<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Programme;
use Faker\Generator as Faker;

$factory->define(Programme::class, function (Faker $faker) {
    return [
        'jour' => $faker->randomElement(['LUNDI','MARDI','MERCREDI','JEUDI','VENDREDI','SAMEDI','DIMANCHE']),
        'heure_debut' => $faker->time,
        'heure_fin' => $faker->time,
        'description' => $faker->sentence,
        'contact' => '696812610',
        'type' => $faker->randomElement(['REGULIER','IRREGULIER']),
        'date_planifiee' => $faker->date,
    ];
});
