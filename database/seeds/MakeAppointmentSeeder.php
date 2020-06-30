<?php

use Illuminate\Database\Seeder;
use App\Models\Request\MakingAppointment;
use App\Models\Request\UserUtype;
use App\Models\Request\ObjectMakingAppointment;

class MakeAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(MakingAppointment::class, 100)->make()->each(function ($usersacrment) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $object = App\Models\Request\ObjectMakingAppointment::all();
            $usersacrment->person_id = $faker->randomElement($user_utypes)->id;
            // $usersacrment->priest_id = $faker->randomElement($user_utypes)->id;
            $usersacrment->object_id = $faker->randomElement($object)->id;
            $usersacrment->save();
        });
    }
}
