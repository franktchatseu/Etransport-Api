<?php

use App\Models\Catechesis\UserCatechesis;
use Illuminate\Database\Seeder;

class UserCatechesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserCatechesis::class, 100)->make()->each(function ($usercatechesis) use ($faker) {
            $users = App\Models\Person\User::all();
            $catechesis = App\Models\Catechesis\Catechesis::all();
            $usercatechesis->user_id = $faker->randomElement($users)->id;
            $usercatechesis->catechesis_id = $faker->randomElement($catechesis)->id;
            $usercatechesis->save();
        });
    }
}
