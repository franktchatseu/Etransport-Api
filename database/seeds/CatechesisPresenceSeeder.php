<?php

use App\Models\Catechesis\CatechesisPresence;
use Illuminate\Database\Seeder;

class CatechesisPresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(CatechesisPresence::class, 100)->make()->each(function ($catechesispresence) use ($faker) {
            $plug = App\Models\Catechesis\Plug::all();
            $usercatechsis = App\Models\Catechesis\UserCatechesis::all();
            $catechesispresence->plug_id = $faker->randomElement($plug)->id;
            $catechesispresence->user_catechesis_id = $faker->randomElement($usercatechsis)->id;
            $catechesispresence->save();
        });
    }
}
