<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Liturgical\LiturgicalText;
use Faker\Generator as Faker;

$factory->define(LiturgicalText::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'contenu' => $faker->sentence,
        'image' => url('https://picsum.photos/200/300'),
    ];
});
