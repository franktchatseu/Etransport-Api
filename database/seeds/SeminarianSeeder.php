<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Seminarian;

class SeminarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Seminarian::class,30)->make()->each(function($seminarian) use ($faker){
            $parish = App\Models\Setting\Parish::all();
            $seminarian->parish_id = $faker->randomElement($parish)->id;
            $seminarian->save();
        });
    }
}
