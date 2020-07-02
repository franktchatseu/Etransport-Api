<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sacrament\Sacrament;
use Faker\Generator as Faker;

$factory->define(Sacrament::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
        'contenu_composition' => $faker->sentence,
        'background_image' => url('/uploads/intentionMass/int.5ef571a1df4803.31291867.png'),
        'composition_file' => url('/uploads/sacraments/document_inscription1593725411.pdf'),
        'inscription_file' => url('/uploads/sacraments/document_inscription1593725411.pdf')
      ];
});
