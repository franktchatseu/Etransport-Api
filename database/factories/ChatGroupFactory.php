<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Messagerie\ChatGroup;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ChatGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name(),
        'reference' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8 ,9])
    ];

});
