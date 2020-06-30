<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\Input;

class InputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Input::class, 200)->make()->each(function ($inputs) use ($faker) {
            $uutypes = App\Models\Person\UserUtype::all();
            $parishs= App\Models\Setting\Parish::all();
            $nature = App\Models\Finance\Nature::all();
            $inputs->user_utype_id = $faker->randomElement($uutypes)->id;           
            $inputs->nature_id = $faker->randomElement($nature)->id;
            $inputs->parish_id = $faker->randomElement($parishs)->id;
            $inputs->save();

        });
    }
}

    
