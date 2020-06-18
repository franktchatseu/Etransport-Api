<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\TimeCard;
use Faker\Generator as Faker;

$factory->define(TimeCard::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(), 
        'description' => $faker->text(), 
        'date' => $faker->date(),    
    ];
});
