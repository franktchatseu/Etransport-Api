<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Liturgical\EntryType;
use Faker\Generator as Faker;

$factory->define(EntryType::class, function (Faker $faker) {
    return [  
        'title' => $faker->text(20),
        'description' => $faker->sentence
    ];
});
