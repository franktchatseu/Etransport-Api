<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' =>  $faker->unique()->sentence,
        'logo' => url('uploads/blogs/blogs.5edba4d14f1dc5.78797280.png'),
        'description' => $faker->sentence,
    ];
});
