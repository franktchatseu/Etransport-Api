<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Messagerie\ChatMemberGroup;

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

$factory->define(ChatMemberGroup::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(['NOT_YET', 'ACCEPTED', 'REJECTED'])
    ];

});
