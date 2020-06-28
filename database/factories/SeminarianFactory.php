<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Seminarian;
use Faker\Generator as Faker;

$factory->define(Seminarian::class, function (Faker $faker) {
    return [
        'picture' => json_encode(['https://picsum.photos/200/300']),
        'name' => $faker->sentence(),
        'description' => $faker->text(),
        'phone' => $faker->bigInteger(),
    ];
});
