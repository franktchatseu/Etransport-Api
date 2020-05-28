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
            $users = App\Models\Person\User::all();
            $sanction = App\Models\Sanction\Sanction::all();
            $usersanction->user_id = $faker->randomElement($users)->id;
            $usersanction->sanction_id = $faker->randomElement($sanction)->id;
            $usersanction->save();
        });
    }
}
