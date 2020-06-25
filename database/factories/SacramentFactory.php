<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sacrament\Sacrament;
use Faker\Generator as Faker;

$factory->define(Sacrament::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
        'composition_file' => url('/uploads/contracts/n_00804_contrat de travail.pdf'),
        'inscription_file' => url('/uploads/contracts/n_00804_contrat de travail.pdf')
      ];
});
