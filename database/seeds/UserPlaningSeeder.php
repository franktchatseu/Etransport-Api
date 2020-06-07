<?php

use App\Models\Planification\UserPlanning;
use Illuminate\Database\Seeder;

class UserPlaningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserPlanning::class, 100)->make()->each(function ($userplaning) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $planing = App\Models\Planification\Planing::all();
            $userplaning->user_utype_id = $faker->randomElement($user_utypes)->id;
            $userplaning->planing_id = $faker->randomElement($planing)->id;
            $userplaning->save();
        });
    }
}
