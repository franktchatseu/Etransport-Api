<?php

use App\Models\Person\Parishional;
use Illuminate\Database\Seeder;

class ParishionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Parishional::class, 100)->make()->each(function ($parishional) use ($faker) {
            $user_utypes = \App\Models\Person\UserUtype::all();
            $parishional->user_utype_id = $faker->randomElement($user_utypes)->id;
            $parishional->save();
        });
    }
}
