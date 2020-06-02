<?php

use Illuminate\Database\Seeder;
use App\Models\Planifications\Planing;

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
            $planing->save();
        });
    }
}
