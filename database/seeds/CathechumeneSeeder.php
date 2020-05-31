<?php

use Illuminate\Database\Seeder;
use App\Models\Person\Cathechumene;
class CathechumeneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Cathechumene::class,100)->make()->each(function($cathechumene) use ($faker){
            $professions = App\Models\Person\Professions::all();
            $cathechumene->profession_id = $faker->randomElement($professions)->id;
            $cathechumene->save();
        });
    }
}