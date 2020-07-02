<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\Association;
use Faker\Generator as Faker;

$factory->define(Association::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'photo' => "/uploads/agenda/logo1.png",
        'description' => $faker->paragraph(),
        'lieu' => $faker->sentence(),
        'rencontre' => $faker->paragraph(),
        'slogan' => $faker->sentence(),
        'dateCreation' => $faker->date(),
        'reglement' => $faker->sentence()
    ];
});
