<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Transfert;
use Faker\Generator as Faker;

$factory->define(Transfert::class, function (Faker $faker) {
    return [
        'motif' => $faker->sentence(),
        'date' => $faker->date(),
        'documents' => $faker->sentence(),
        'status' => $faker->randomElement(['PENDING', 'REFUSED', 'ACCEPTED']),
    ];
});
