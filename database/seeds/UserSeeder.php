<?php

use App\Models\Person\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(User::class, 20)->make()->each(function ($user) use ($faker) {
            $professions = \App\Models\Person\Profession::all();
            $user->profession_id = $faker->randomElement($professions)->id;
            $user->save();
        });
    }
}
