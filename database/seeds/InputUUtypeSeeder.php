<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\InputUUtype;

class InputUUtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(InputUUtype::class, 100)->make()->each(function ($uutype) use ($faker) {
            $inputs = App\Models\Finance\Input::all();
            $uutypes = App\Models\Person\UserUtype::all();

            $uutype->user_utype_id = $faker->randomElement($uutypes)->id;
            $uutype->input_id = $faker->randomElement($inputs)->id;
            $uutype->save(); 
        });
    }
}
