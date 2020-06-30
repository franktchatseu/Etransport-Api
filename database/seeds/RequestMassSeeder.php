<?php

use Illuminate\Database\Seeder;
use App\Models\Request\UserUtype;
use App\Models\Request\ObjectRequestMass;
use App\Models\Request\RequestMass;

class RequestMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(RequestMass::class, 100)->make()->each(function ($usersacrment) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $priests = App\Models\Person\UserUtype::where(['utypes.value' => 'PRIEST']) 
            ->join('utypes', ['utypes.id' => 'user_utypes.type_id' ])->get();
            $object = App\Models\Request\ObjectRequestMass::all();
            $usersacrment->person_id = $faker->randomElement($user_utypes)->id;
            $usersacrment->priest_id = $faker->randomElement($priests)->id;
            $usersacrment->object_id = $faker->randomElement($object)->id;
            $usersacrment->save();
        });
    }
}
