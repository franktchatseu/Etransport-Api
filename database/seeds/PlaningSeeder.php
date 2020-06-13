<?php

use App\Models\Planification\Planing;
use Illuminate\Database\Seeder;

class PlaningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Planing::class,100)->make()->each(function($planing) use ($faker){
            $planingtype = App\Models\Planification\TypePlaning::all();
            $planing->type_id = $faker->randomElement($planingtype)->id;
            $planing->save();
        });
    }
}
