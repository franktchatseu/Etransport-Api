<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Authorization;
use Faker\Generator as Faker;

$factory->define(Authorization::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'description' => $faker->sentence(),
        'documents' => json_encode(['https://picsum.photos/200/300']),
    ];
});
