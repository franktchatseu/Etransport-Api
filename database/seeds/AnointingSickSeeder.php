<?php

use Illuminate\Database\Seeder;
use App\Models\Request\AnointingSick;
use App\Models\Person\UserUtype;


class AnointingSickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(AnointingSick::class, 10)->make()->each(function ($anoitingSick) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $anoitingSick->person_id = $faker->randomElement($user_utypes)->id;
            $anoitingSick->save();
        });
    }
}
