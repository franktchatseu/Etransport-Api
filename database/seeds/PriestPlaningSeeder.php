<?php

use Illuminate\Database\Seeder;
use App\Models\Planification\PriestPlaning;

class PriestPlaningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(PriestPlaning::class, 10)->make()->each(function ($priestplaning) use ($faker) {
            $user = App\Models\Person\User::all();
            $userutype = App\Models\Person\UserUtype::all();
            $time = App\Models\Planification\Time::all();
            $priestplaning->time_id = $faker->randomElement($time)->id;
            $priestplaning->user_id = $faker->randomElement($user)->id;
            $priestplaning->userutypes_id = $faker->randomElement($userutype)->id;
            $priestplaning->save();
        });
    }
}
