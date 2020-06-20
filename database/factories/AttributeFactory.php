<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Attribute;
use Faker\Generator as Faker;

$factory->define(Attribute::class, function (Faker $faker) {
    return [
        'name' =>  $faker->unique()->sentence,
        'type' => $faker->randomElement(['text', 'entier', 'boolean']),
    ];
});
