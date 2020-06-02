<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Catechesis;
use Faker\Generator as Faker;

$factory->define(Catechesis::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),  
        'description' => $faker->sentence(),        
    ];
});
