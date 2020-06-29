<?php

use App\Models\Person\Priest;
use Illuminate\Database\Seeder;

class PriestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {    
        factory(Priest::class, 10)->make()->each(function ($priest) use ($faker) {
            $user_utypes = \App\Models\Person\UserUtype::all();
            $parishs = App\Models\Setting\Parish::all();
            $priest->user_utype_id = $faker->randomElement($user_utypes)->id;
            $priest->parish_id = $faker->randomElement($parishs)->id;
            $priest->save();
        });
    }
}
