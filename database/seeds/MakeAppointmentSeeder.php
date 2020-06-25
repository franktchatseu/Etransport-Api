<?php

use Illuminate\Database\Seeder;
use App\Models\Request\MakingAppointment;

class MakeAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(MakingAppointment::class, 100)->make()->each(function ($usersacrment) use ($faker) {
            $user_utypes = App\Models\Person\UserUtype::all();
            $object = App\Models\Request\ObjectMakingAppointment::all();
            $usersacrment->user_utype_id = $faker->randomElement($user_utypes)->id;
            $usersacrment->sacrament_id = $faker->randomElement($object)->id;
            $usersacrment->save();
        });
    }
}
