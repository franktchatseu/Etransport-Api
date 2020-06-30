<?php

use Illuminate\Database\Seeder;
use App\Models\Request\IntentionMass;
use App\Models\Request\UserUtype;

class IntentionMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(IntentionMass::class, 100)->make()->each(function ($intentionmass) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $mass = App\Models\Setting\MassShedule::all();
            $intentionmass->person_id = $faker->randomElement($user_utypes)->id;
            $intentionmass->mass_id = $faker->randomElement($mass)->id;
            $intentionmass->save();
        });
    }
}
