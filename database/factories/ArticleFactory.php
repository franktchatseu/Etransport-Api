<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'name' =>  $faker->unique()->sentence,
        'photo' => '',
        'titre' => $faker->unique()->sentence,
        'date_de_publication' => $faker->date('2010-03-12', '2020-03-12'),
        'contenu_1' => $faker->text(200),
        'contenu_1' => $faker->text(200),
        'fichier' => ''

    ];
});

