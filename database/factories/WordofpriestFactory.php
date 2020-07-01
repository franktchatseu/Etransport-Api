<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Setting\Wordofpriest;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Wordofpriest::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'picture_priest' => "/uploads/logo1.png",
        'contenu' =>  $faker->text(),
    ];
});
