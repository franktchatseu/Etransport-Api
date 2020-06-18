<?php

use App\Models\Place\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Place::class, 10)->make()->each(function ($place) use ($faker) {
            $city = App\Models\Place\City::all();
            $placetype = App\Models\Place\TypePlace::all();
            $place->city_id = $faker->randomElement($city)->id;
            $place->type_id = $faker->randomElement($placetype)->id;
            $place->save();
        });
    }
}
