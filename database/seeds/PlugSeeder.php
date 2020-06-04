<?php

use App\Models\Catechesis\Plug;
use Illuminate\Database\Seeder;

class PlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Plug::class, 10)->make()->each(function($plug) use ($faker){
            $patterns = App\Models\Catechesis\Pattern::all();
            $plug->pattern_id = $faker->randomElement($patterns)->id;
            $plug->save();
        });
    }
}
