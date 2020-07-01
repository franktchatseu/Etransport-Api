<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Wordofpriest;
use App\Models\Setting\Parish;
class WordofpriestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Wordofpriest::class, 21)->make()->each(function ($wordofpriest) use ($faker) {
            $parish = Parish::all();
            $wordofpriest->parish_id = $faker->randomElement($parish)->id;
            $wordofpriest->save();
        });
    }
}
