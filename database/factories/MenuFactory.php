<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        //
        'name' =>  $faker->unique()->sentence,
        'logo' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
