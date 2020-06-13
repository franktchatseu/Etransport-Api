<?php

use App\Models\Catechesis\CathedralPresence;
use Illuminate\Database\Seeder;

class CathedralPresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(CathedralPresence::class, 100)->make()->each(function ($cathedralpresence) use ($faker) {
            $plugs = App\Models\Catechesis\Plug::all();
            $cathechesis = App\Models\Catechesis\Catechesis::all();
            $annualmember = App\Models\Catechesis\AnnualMember::all();
            $cathedralpresence->plug_id = $faker->randomElement($plugs)->id;
            $cathedralpresence->cathechesis_id = $faker->randomElement($cathechesis)->id;
            $cathedralpresence->annual_member_id = $faker->randomElement($annualmember)->id;
            $cathedralpresence->save();
        });
    }
}
