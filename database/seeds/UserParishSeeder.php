<?php

use App\Models\Setting\Parish;
use App\Models\Setting\UserParish;
use Illuminate\Database\Seeder;

class UserParishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserParish::class, 100)->make()->each(function ($userparish) use ($faker) {
            $user_utype = \App\Models\Person\UserUtype::all();
            $parish = App\Models\Setting\Parish::all();
            $userparish->user_utype_id = $faker->randomElement($user_utype)->id;
            $userparish->parish_id = $faker->randomElement($parish)->id;
            $userparish->save();
            
        });
    }
}
