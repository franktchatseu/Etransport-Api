<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\TypeAssociation;
use Faker\Generator as Faker;

$factory->define(TypeAssociation::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name(),
        'description' => $faker->paragraph(),
    ];
});
