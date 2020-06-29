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
            $user_utypes = App\Models\Person\UserUtype::all();
            $planing->type_id = $faker->randomElement($planingtype)->id;
            $planing->user_utype_id = $faker->randomElement($user_utypes)->id;
            $planing->save();
        });
    }
}
