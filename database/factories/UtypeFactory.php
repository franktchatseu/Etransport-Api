<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Person\Utype;

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

$factory->define(Utype::class, function (Faker $faker) {
    return [
        // 'user_type' => $faker->randomElement(['PRIEST', 'CATECHIST', 'CATECHUMEN', 'PARISHIONER', 'OTHER']),
    ];

});
