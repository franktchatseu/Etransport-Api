<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'name' =>  $faker->unique()->sentence     
    ];
});

