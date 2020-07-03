<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Article_Attribute_Menu;
use Faker\Generator as Faker;

$factory->define(Article_Attribute_Menu::class, function (Faker $faker) {
    return [
        'value' =>  $faker->unique()->sentence,
    ];
});
