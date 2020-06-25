<?php

use Illuminate\Database\Seeder;
use App\Models\Request\ObjectMakingAppointment;

class ObjectMakingAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(ObjectMakingAppointment::class, 100)->make()->each(function ($usersacrment) use ($faker) {
            $usersacrment->save();
        });
    }
}
