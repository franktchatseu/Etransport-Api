<?php

use Illuminate\Database\Seeder;
use App\Models\Person\UserUtype;

class UserUtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(App\Models\Person\UserUtype::class, 20)->make()->each(function ($uutype) use ($faker) {
            $users = App\Models\Person\User::all();
            $utypes = App\Models\Person\Utype::all();
            $parish = App\Models\Setting\Parish::all();
            
            $uutype->user_id = $faker->randomElement($users)->id;
            $uutype->type_id = $faker->randomElement($utypes)->id;
            $uutype->parish_id = $faker->randomElement($parish)->id;
            $uutype->save();
        });
    }
}
