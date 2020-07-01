<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Setting\Wordofpriest;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Wordofpriest::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'contenu' =>  $faker->text(),
    ];
});
