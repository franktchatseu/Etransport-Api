<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
