<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Parish_theme;
use App\Model;
use Faker\Generator as Faker;


$factory->define(Parish_theme::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'image' => "/uploads/logo1.png",
        'contenu' =>  $faker->text(),
    ];
});
