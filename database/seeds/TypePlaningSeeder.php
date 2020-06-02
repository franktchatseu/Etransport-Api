<?php

use Illuminate\Database\Seeder;
use App\Modls\Planification\TypePlaning;

class TypePlaningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(TypePlaning::class,100)->make()->each(function($typeplaning) use ($faker){
            $typeplaning->save();
        });
    }
}
