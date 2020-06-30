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
            $user_utypes = \App\Models\Person\UserUtype::all();
            $catechesis = App\Models\Catechesis\Catechesis::all();
            $usercatechesis->user_utype_id = $faker->randomElement($user_utypes)->id;
            $usercatechesis->catechesis_id = $faker->randomElement($catechesis)->id;
            $usercatechesis->save();
        });
    }
}
