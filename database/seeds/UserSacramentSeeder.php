<?php

use App\Models\Sacrament\UserSacrament;
use Illuminate\Database\Seeder;

class UserSacramentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(UserSacrament::class, 100)->make()->each(function ($usersacrment) use ($faker) {
            $users = App\Models\Person\User::all();
            $sanction = App\Models\Sacrament\Sacrament::all();
            $usersacrment->user_id = $faker->randomElement($users)->id;
            $usersacrment->sacrament_id = $faker->randomElement($sanction)->id;
            $usersacrment->save();
        });
    }
}
