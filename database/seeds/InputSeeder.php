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
        factory(Input::class, 100)->make()->each(function ($inputs) use ($faker) {
            $nature = App\Models\Finance\Nature::all();
            $inputs->nature_id = $faker->randomElement($nature)->id;
            $inputs->save();
        });
    }
}

    
