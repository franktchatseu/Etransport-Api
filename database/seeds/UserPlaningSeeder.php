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
            $user = App\Models\Person\User::all();
            $planing = App\Models\Planification\Planing::all();
            $userplaning->user_id = $faker->randomElement($user)->id;
            $userplaning->planing_id = $faker->randomElement($planing)->id;
            $userplaning->save();
        });
    }
}
