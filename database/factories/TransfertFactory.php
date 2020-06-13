<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Transfert;
use Faker\Generator as Faker;

$factory->define(Transfert::class, function (Faker $faker) {
    return [
        'motif' => $faker->sentence(),
        'date' => $faker->date(),
        'documents' => json_encode(['https://picsum.photos/200/300']),
        'status' => $faker->randomElement(['PENDING', 'REJECTED', 'ACCEPTED']),
    ];
});
