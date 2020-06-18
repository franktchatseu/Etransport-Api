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
            $user_utypes = App\Models\Person\UserUtype::all();
            $sanction = App\Models\Sacrament\Sacrament::all();
            $usersacrment->user_utype_id = $faker->randomElement($user_utypes)->id;
            $usersacrment->sacrament_id = $faker->randomElement($sanction)->id;
            $usersacrment->save();
        });
    }
}
