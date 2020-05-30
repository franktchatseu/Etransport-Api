<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'basic_amount' =>  $faker->money_format,
        'percentage' => $faker->numberBetween(0,100),
        'final_amount' =>  $faker->money_format,
        'accounttype_id' =>  $faker->number_format,
    ];
});
