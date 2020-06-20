<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Attribute_Menu;
use Faker\Generator as Faker;

$factory->define(Attribute_Menu::class, function (Faker $faker) {
    return [
        'is_required' =>  $faker->boolean(),
        'min_length' =>  $faker->numberBetween(1,10),
        'max_length' =>  $faker->numberBetween(10,100),           
    ];
});
