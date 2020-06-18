<?php

use App\Models\Sanction\UserSanction;
use Illuminate\Database\Seeder;

class UserSanctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserSanction::class, 100)->make()->each(function ($usersanction) use ($faker) {
            $user_utypes = App\Models\Person\User::all();
            $sanction = App\Models\Sanction\Sanction::all();
            $usersanction->user_utype_id = $faker->randomElement($user_utypes)->id;
            $usersanction->sanction_id = $faker->randomElement($sanction)->id;
            $usersanction->save();
        });
    }
}
